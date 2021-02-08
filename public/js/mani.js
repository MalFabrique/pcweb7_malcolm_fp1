// only admins should be able edit/delete calendar

$(document).ready(function () {

  alert();
  Date.prototype.toDateInputValue = (function () {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0, 10);
  });
  // console.log(moment().format('LLLL'));  // 'Friday, June 24, 2016 1:42 AM'

  load_meetings();
  // fullCalendar starts
  let calendar = $('#calendar').fullCalendar({
    editable: true,
    header: {
      left: 'prev, next, today',
      center: 'title',
      right: 'month, agendaWeek, agendaDay'

    },
    events: 'load.php',
    selectable: true,
    selectHelper: true,
    select: function (start, end, allDay) {
      var title = prompt("Please Enter Meeting Title");

      if (title === null || title.length < 3) {
        alert('PLease Enter a descriptive meeting name');
        return;
      }

      // alert('title is', title);
      // return;
      if (title) {
        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");


        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");



        $.ajax({
          url: "action.php",
          type: "POST",
          data: { query: 'create_meeting', title: title, start: start, end: end },
          success: function (data) {

            console.log('Result is: ', data);
            calendar.fullCalendar('refetchEvents');
            alert('Added Successfully');
          }
        })
      }
    },
    editable: true,
    eventResize: function (event) {
      console.log('event', event);
      var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");

      var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");

      var title = event.title;
      var id = event.id;
      $.ajax({
        url: "update.php",
        type: "POST",
        data: { title: title, start: start, end: end, id: id },
        success: function (data) {
          console.log('update result', data);
          calendar.fullCalendar('refreshEvents');
          alert('Event Update');
        }

      })
    },
    eventDrop: function (event) {
      console.log('event', event);
      var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");

      var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");

      var title = event.title;
      var id = event.id;

      $.ajax({
        url: "update.php",
        type: "POST",
        data: { title, title, start, start, end: end, id: id },
        success: function (data) {
          console.log('sec update', data);
          calendar.fullCalendar('refetchEvents');
          alert('Event Updated');
        }
      })
    },
    eventClick: function (event) {
      var confirm_delete = confirm('Are you sure you want to delete the meeting?');

      if (confirm_delete) {
        var id = event.id;

        $.ajax({
          url: "delete.php",
          type: "POST",
          data: { id: id },
          success: function (data) {
            console.log(data);
            calendar.fullCalendar('refetchEvents');

            alert("Meeting Deleted");

          }
        })
      }
    }
  });
  // full calendar ends here 




  function load_meetings() {
    $.ajax({
      url: "action.php",
      type: "POST",
      data: { query: 'getMeetings' },
      success: function (data) {


        console.log(data);


        var { result } = JSON.parse(data);
        var resultDiv = '';
        result.map(res => {
          resultDiv += `<span><h5>${res.title}</h5>
          <span>
          <b>Starts:</b>
          ${moment(res.start)}
          </span>
          <span>
          <b>Ends:</b>

          ${moment(res.end)}
          </span>
          <span>
          <button data-modal-trigger="modal-example-basic"  data-id=${res.id} data-title="${res.title}" data-start="${res.start}" data-end="${res.end}" class="edit_meeting rvt-button">Edit</button>
          </span>
          <span><button meeting_id=${res.id} class="delete_meeting rvt-button rvt-button--danger">Delete</button></span>
          </span>
          <span><a  target="_blank" href="meeting_info.php?meeting_id=${res.id}" class=" rvt-button rvt-button--success">Meeting Info</a></span>
          </span>
          `;
        });





        $("#meetings_list").html(resultDiv);
        delete_meeting();
        // load_members();
      }
    })
  }

  // end of load meetings 


  // on click on add participants modal 




  // delete meeting

  function delete_meeting() {
    $(".delete_meeting").on('click', function (e) {
      e.preventDefault();

      const value = $(this).attr('meeting_id');

      $.ajax({
        url: "delete.php",
        type: "POST",
        data: { id: value },
        success: function (data) {
          console.log(data);
          // calendar.fullCalendar('refetchEvents');

          alert("Meeting Deleted");
          window.location.reload();

        }
      })


    })

  }
  // End of delete meeting 

  // choose meeting participants


  // function load_members() {
  //   // return;

  //   $.ajax({
  //     url: 'action.php',
  //     type: "POST",
  //     data: { query: 'getAllUsers' },
  //     success: function (data) {
  //       var { result } = JSON.parse(data);
  //       var resultDiv = '';
  //       result.map(res => {
  //         resultDiv += `
  //         <p>
  //         <input class="meeting_participants" type="checkbox" name="checkbox-demo" data-id="${res.id}" id="${res.id}" username="${res.username}">
  //           <label for="${res.id}" class="rvt-m-right-sm">${res.username}</label>
  //         </p>
  //       `;
  //       })


  //       var def = `<form>
  //       <fieldset>
  //           <legend class="sr-only">Checkbox list</legend>
  //             ${resultDiv}
  //           </legend>
  //       </fieldset>
  //           </form > `;



  //       $(".rvt-modal__body").html(def);

  //     }
  //   })
  // }




  // on click of confirm meeting members

  $("#confirm_members").on("click", function (e) {
    confirm_participants();
  })


  // pass meeting details to edit  modal 
  $(document).on("click", ".edit_meeting", function () {
    var meeting_id = $(this).data('id');
    var meeting_title = $(this).data('title');
    var meeting_start = $(this).data('start');
    var meeting_end = $(this).data('end');


    // meeting_start = Date.parse(meeting_start);

    meeting_start = moment(meeting_start).format("yyyy-MM-ddThh:mm:ss");
    // meeting_start = GetFormattedDate(meeting_start);

    console.log('meeting_start', meeting_start)
    $("#edit_meeting_title").val(meeting_title);
    $("#edit_meeting_id").val(meeting_id);

    // $("#edit_meeting_end").val(meeting_end);

  });




  $(document).on("click", "#edit_meeting_submit", function () {
    var meeting_id = $("#edit_meeting_id").val();
    var meeting_title = $("#edit_meeting_title").val();
    var meeting_start = $("#edit_meeting_start").val();
    var meeting_end = $("#edit_meeting_end").val();

    var notes = $("#textarea-info-state").val();







    var start = meeting_start;

    var end = meeting_end;

    var title = meeting_title;
    var id = meeting_id;
    $.ajax({
      url: "update.php",
      type: "POST",
      data: { title: title, start: start, end: end, id: id, notes: notes },
      success: function (data) {
        console.log('update result', data);
        alert('Meeting Updated');
      }

    })



  })







})
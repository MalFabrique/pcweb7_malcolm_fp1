<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FamBond') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'FamBond') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}">My Profile</a>
                            </li>

                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('myfamily') }}">My Family</a>
                            </li>

                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('calendar') }}">Calendar</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('post.create') }}">Post Now!</a>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                  

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>







    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" defer></script>


<script>
  
  // only admins should be able edit/delete calendar

$(document).ready(function () {

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
  events: '/meetings',
  selectable: true,
  selectHelper: true,
  select: function (start, end, allDay) {
    var title = prompt("Please Enter Meeting Title");
    console.log('title is: ', title)


    if (title === null || title.length < 3) {
      alert('PLease Enter a descriptive meeting name');
      return;
    }

    // alert('title is', title);
    // return;
    if (title) {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");


      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


      $.ajax({
        url: "/meetings",
        type: "POST",
        cache: false, 
        data: { title: title, start: start, end: end },
        success: function (data) {

          console.log('Result is: ', data);
          calendar.fullCalendar('refetchEvents');
        }, 
        error: function(err){
            console.log(err.responseText)
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
      url: "/meetings/update",
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

      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

      $.ajax({
        url: "/meetings/delete",
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
    url: "/meetings",
    type: "GET",
    success: function (data) {


        
        
        
        var result  = data.reverse();
        
      var resultDiv = '';
      result.map(res => {
        resultDiv += `<div class=" mb-2">
                        <div class="row">
                        <h5 class="mr-3">${res.title}</h5>
                        </div>
                        <span><b>Starts:</b>${moment(res.start)}</span>
                        <span><b>Ends:</b>${moment(res.end)}</span>
                        <span><button meeting_id=${res.id} class="btn btn-sm btn-danger">Delete</button></span>
                        
      
        </div>
        <hr>`;
      });



      console.log(resultDiv);


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

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: "/meetings/delete",
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
    url: "/meetings/update",
    type: "POST",
    data: { title: title, start: start, end: end, id: id, notes: notes },
    success: function (data) {
      console.log('update result', data);
      alert('Meeting Updated');
    }

  })



})







})
  
  </script>

</body>
</html>

import Echo from 'laravel-echo';
import './bootstrap';


// Subscribe to the private channel
window.Echo.private('classroom.' + classroomId)
   .listen('.classwork-created', function(event) {
      alert(event.title);
   });


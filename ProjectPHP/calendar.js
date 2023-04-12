document.addEventListener('DOMContentLoaded', function () {
    const eventListItems = document.querySelectorAll('.event-list li');
    const eventModal = document.getElementById('eventInfoModal');
    const eventInfoTitle = document.getElementById('eventInfoTitle');
    const eventInfoDate = document.getElementById('eventInfoDate');
    const eventInfoColor = document.getElementById('eventInfoColor');
    const closeEventInfoModal = document.querySelector('.event-info-close');
    const eventInfoForm = document.getElementById('eventInfoForm');
    const eventInfoID = document.getElementById('eventInfoID');
    eventListItems.forEach(item => {
        item.addEventListener('click', function () {
            eventInfoTitle.value = this.innerText;
            eventInfoDate.value = this.getAttribute('data-date');
            eventInfoID.value = this.getAttribute('data-date-time');
            eventInfoColor.value = 'red'; 
            eventModal.style.display = 'block';
        });
    });

    eventInfoForm.addEventListener('submit', function (event) {
        event.preventDefault();

        // Get the data from the form
        const title = (eventInfoTitle.value).toString();
        const dateTime = eventInfoDate.value.toString();
        const color = eventInfoColor.value.toString();
        const eventID = eventInfoID.value.toString();    

    
        fetch('server.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              action: 'updateEvent',
              title: title,
              dateTime: dateTime,
              color: color,
              eventID: eventID,
            })
          })
          .then(response => response.json())
          .then(data => {
            console.log(data);
          })
          .catch(error => {
            console.log(error)
            console.log(title, dateTime, color, eventID)
          });
    });

    closeEventInfoModal.addEventListener('click', function () {
        eventModal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target === eventModal) {
            eventModal.style.display = 'none';
        }
    });
});
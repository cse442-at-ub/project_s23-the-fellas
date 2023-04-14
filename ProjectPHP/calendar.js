document.addEventListener('DOMContentLoaded', function () {
    const eventListItems = document.querySelectorAll('.event-list li');
    const eventModal = document.getElementById('eventInfoModal');
    const eventInfoTitle = document.getElementById('eventInfoTitle');
    const eventInfoDate = document.getElementById('eventInfoDate');
    const eventInfoColor = document.getElementById('eventInfoColor');
    const closeEventInfoModal = document.querySelector('.event-info-close');
    const eventInfoForm = document.getElementById('eventInfoForm');
    const eventInfoID = document.getElementById('eventInfoID');
  
    //When you click on an event, the modal opens and the event info is displayed
    function updateEventListener(item) {
        item.addEventListener('click', function () {
            eventInfoTitle.value = this.innerText;
            eventInfoDate.value = this.getAttribute('data-date');
            eventInfoID.value = this.getAttribute('data-date-time');
            eventInfoColor.value = this.getAttribute('data-color').trim();
            console.log('x', this.getAttribute('data-color').trim(), 'x');
            eventModal.style.display = 'block';
        });
    }
    
    eventListItems.forEach(item => {
        updateEventListener(item);
    });
  
    //Sends the updatEvent action to the server (server.php) and updates the event in the database
    eventInfoForm.addEventListener('submit', function (event) {
        event.preventDefault();
  
        // Get the data from the form
        const title = (eventInfoTitle.value).toString();
        const dateTime = eventInfoDate.value.toString();
        const color = eventInfoColor.value.toString();
        const eventID = eventInfoID.value.toString();
        console.log(title, dateTime, color, eventID);
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
        .then(response => response.text())
        .then(data => {
            // Update the corresponding list item
            const listItem = document.getElementById(`event-item-${eventID}`);
            if (listItem) {
                listItem.innerText = title;
                listItem.setAttribute('data-date', dateTime);
                // Update other attributes if needed
                updateEventListener(listItem); // Update the event listener for the updated list item
            }
            // Close the modal after updating the event
            eventModal.style.display = 'none';
            location.reload();
        })
        .catch(error => {
            console.log(error);
            console.log(title, dateTime, color, eventID);
        });
    });
  
    //When you click outside the modal or on the close button, the modal closes
    closeEventInfoModal.addEventListener('click', function () {
        eventModal.style.display = 'none';
    });
  
    //When u click ON the modal it will stay open and not close
    window.addEventListener('click', function (event) {
        if (event.target === eventModal) {
            eventModal.style.display = 'none';
        }
    });
  });
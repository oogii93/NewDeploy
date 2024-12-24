const { update } = require("lodash")

document.addEventListener('DOMContentLoaded', function(){
    function checkNotification(){
        fetch('check-notifications', {
            method:'GET',
            headers:{
                'X-Requested-With' :'XMLHttpRequest',
                'Accept':'application/json'
            },

        })
        .then(response =>response.json())
        .then(data=>{
            updateNotificationDots(data);
        });
    }


    function updateNotificationDots(data){
               // Update each navigation item's notification dot

               if(data.newOrders >0){
                document.querySelector('[data-notification="orders"]')
                ?.classList.remove('hidden');

               }
    }

    setInterval(checkNotification, 30000);

    chechNotifications();
});

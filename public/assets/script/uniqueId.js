window.addEventListener('DOMContentLoaded', (e) => {
     function getCookie(cname) {
          let name = cname + "=";
          let ca = document.cookie.split(';');
          for(let i = 0; i < ca.length; i++) {
               let c = ca[i];
               while (c.charAt(0) == ' ') {
               c = c.substring(1);
          }
               if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
               }
          }
          return "";
     }

     const deviceIdExisted = getCookie("device_id");
     let device_id;
     if(deviceIdExisted === ""){
          device_id = Date.now() + Math.floor(Math.random(1000) * 100);
          document.cookie = `device_id=${device_id};`;
     }else{
          device_id = deviceIdExisted;
     }
});
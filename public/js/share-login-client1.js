document.addEventListener('DOMContentLoaded', () => {
  // Connect to Cross Storage Hub
  const storage = new CrossStorageClient(shareLogin.plugin_url + 'public/partials/share-login-storage.html');
  function getCookie(cname) {
      let name = cname + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let ca = decodedCookie.split(';');
      for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "Not found Cookie";
  }
  // Set data
  storage.onConnect()
      .then(() => {
      return storage.set('sl_token_recieved', getCookie('sl_token'));
      })
      .then(() => {
      console.log('Data successfully set by Client 1.', getCookie('sl_token'));
      })
      .catch(err => {
      console.error('Error in Client 1:', err);
      });

});


document.addEventListener('DOMContentLoaded', () => {
  // Connect to Cross Storage Hub
      const storage = new CrossStorageClient(shareLogin.main_site_url + '/wp-content/plugins/share-login/public/partials/share-login-storage.html?hub_js_url=' + shareLogin.hub_js_url);
  
      // Get data
      storage.onConnect()
        .then(() => {
          return storage.get('slogin_token_recieved');
        })
        .then(data => {
          console.log('Data retrieved by Client 2:', data);
          // If cookie exists, update its value, otherwise create new cookie
          document.cookie = "slogin_token_recieved=" + data + "; path=/";
        })
        .catch(err => {
          console.error('Error in Client 2:', err);
        });
  
  });
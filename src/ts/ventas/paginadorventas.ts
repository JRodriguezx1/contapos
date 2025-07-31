(()=>{
    if(document.querySelector('.paginadorventas')){

      var options = {
        valueNames: [ 'card-title', 'card-category'],
        page: 15,
        pagination: true,
      };

      var hackerList = new List('hacker-list', options);
      }

})();
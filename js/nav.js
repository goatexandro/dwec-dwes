const navegation= async function() {
   
      const navbar = document.getElementById("navbar");
      const response = await fetch("./nav.html");  
      const data = await response.text();  
      navbar.innerHTML = data;  
      
      console.log(response);
      const links = navbar.querySelectorAll('a');
      const currentPage = window.location.pathname.split('/').pop();  
  
      links.forEach(link => {
        if (link.href.includes(currentPage)) {
          link.classList.add('active');  
        }
      });
    
  };

  navegation();
  
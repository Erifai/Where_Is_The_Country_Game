
		let b1 = document.getElementById("b1");
		let d1 = document.getElementById("1");
		let d2 = document.getElementById("2");
		let b3 = document.getElementById("b3");
		let btn = b1.textContent;
	  
		
		function togg(){	
		 if(btn === "se connecter")
		   {
		    b1.addEventListener("click", () => {
		    document.querySelector("#b1").innerHTML = "s'inscrire";
			d1.style.display = "none";
			d2.style.display = "block";
			btn = "s'inscrire";
				  
											   })
		 							   
		  }		
		  else {
			b1.addEventListener("click", () => {
			document.querySelector("#b1").innerHTML = "se connecter";
			d1.style.display = "block";
			d2.style.display = "none";
			btn = "se connecter";
		                                         })
		  }	
		 
		
	  };
	
	  function togg2(){
		b3.addEventListener("click", () => {
			d1.style.display =  "none";
			d2.style.display = "block";
		})
	  };
	 
	  b1.onclick = togg;
	  b3.onclick = togg2;
	  
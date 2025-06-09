//check email exist or not
var isEmailExists = false; 
            function checkemailexist(email){ 
                    var xhr = new XMLHttpRequest(); 
                    
                    xhr.open('GET', 'check_email.php?email=' + email, true);
                
                    xhr.onreadystatechange = function () { 
                        if (xhr.readyState==4 && xhr.status == 200) {
                            var response = xhr.responseText.trim(); 
                            var emailError=document.getElementById("emailError");
                            if(response=="1"){
                                emailError.textContent = ("Email already exist");
                                isEmailExists = true;                                   
                                
                                
                            }
                            else { 
                                emailError.textContent = "";  
                                isEmailExists = false;                            
                                
                            }                            
                        }                          
                    };
                    xhr.send();  
                    
            } 

            document.getElementById("email").addEventListener("blur",function(){ 
                var email=document.getElementById("email").value; 
                if(email){ 
                    checkemailexist(email);
                    
                }
            });

            function formvalidation()
            {   var isvalid=true;
                document.querySelectorAll('.error').forEach(function(clear){
                    clear.textContent='';
                }); 

                
                //name validation  
                var name=document.getElementById("name").value;
                var nameError=document.getElementById("nameError");
                if(name==""||!/[a-zA-Z]/.test(name)||/[0-9]/.test(name)){
                    nameError.textContent=("Name cannot be empty and contain only letters");
                    isvalid=false;  
                }
                //email validation   
                var email=document.getElementById("email").value;
                var emailError=document.getElementById("emailError");
                if(email==""){
                    emailError.textContent=("Enter Email");
                    isvalid=false;   
                } else {
                // Check if email exists in the database 
                if (isEmailExists) {
                    emailError.textContent = ("Email already registered");
                    isvalid = false;
                }
                }
                 /*else {
                    
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'check_email.php', true); 
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        if (xhr.readyState==4 &&xhr.status == 200) {
                            if (xhr.responseText == 'exist') {
                                emailError.textContent = ("Email already exists");
                                isvalid = false;
                            }
                            else {
                                
                                emailError.textContent = ''; 
                            }
                        } 
                    };
                    xhr.send("email=" + encodeURIComponent(email));
                    
                }*/
                
                
                var at=email.indexOf("@");
                var dot=email.lastIndexOf(".");
                var emailError=document.getElementById("emailError");
                if(at<1||dot<=at-2){
                    emailError.textContent=("Enter valid Email");
                    isvalid=false;
                } 

                //password validation 
                var pass1=document.getElementById("pass1").value;
                var pass1Error=document.getElementById("pass1Error");
                if(pass1==""||pass1.length<8||!/[a-z]/.test(pass1)||!/[A-Z]/.test(pass1)||!/[0-9]/.test(pass1)){
                    pass1Error.textContent=("Password must be minimum 8 characters and atleast one uppercase letter,lowercase letter and one number required");
                    isvalid=false;
                }
                
                //confirm password
                var pass2=document.getElementById("pass2").value;
                var pass2Error=document.getElementById("pass2Error");
                if(pass1!=pass2){
                    pass2Error.textContent=("Password must be same");
                    isvalid=false;
                }
                //gender validation
                var gender=document.querySelector('input[name="gender"]:checked');
                var genderError=document.getElementById("genderError");
                if(!gender){
                    genderError.textContent=("Select the Gender");
                    isvalid=false;

                }
                //country validation
                var country=document.getElementById("country").value;
                var countryError=document.getElementById("countryError");
                if(country==""){
                    countryError.textContent=("Select Country");
                    isvalid=false;
                }
                //terms validation
                var check=document.getElementById("check").checked;
                var checkError=document.getElementById("checkError");
                if(!check){
                   checkError.textContent=("The checkbox should be checked before form submission");
                   isvalid=false;  
                }
                if(isvalid){
                    alert("Form Submitted successfully");
                return true; 
                }
                else{
                    alert("Please fill out the form correctly");
                    return false;
                } 
            }     
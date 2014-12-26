function posaljiPodatke(){
                        var fields = $("#myForm").serializeArray();
                        var podaci = new Object();
                        jQuery.each( fields, function(i, field ) {
                            podaci[ field.name] = field.value;
                         });
                        var formData = JSON.stringify(podaci);
                        alert("hahahahah");
                        
                        $.ajax({
                            url: "../server/server.php",
                            type: "get",
                            dataType: "json",
                            data: formData,
                            success: function(book_data, statusText, jqxhr){

                               

                            },
                            error: function(result, statusText, jqxhr){
                                
                            }

                        });
                    }
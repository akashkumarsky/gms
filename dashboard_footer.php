</section>
<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
            arrowParent.classList.toggle("showMenu");
        });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });

    $(document).ready(function() {
        function loadData(type, cat_id = null) {
            $.ajax({
                url: "auth/data.php",
                type: "POST",
                data: {
                    type: type,
                    id: cat_id
                },
                success: function(data) {
                    if (type == 'ward') {
                        $("#ward").append(data);
                    } else if (type == 'dept') {
                        $("#dept").append(data);
                    } else if (type == 'mode') {
                        $("#mode").append(data);
                    } else {
                        $("#zone").append(data);
                    }
                }
            });
        }

        loadData();

        $("#zone").on("change", function() {
            var zone = $("#zone").val();

            loadData('ward', zone);
        });

        $("#dept").one("click", function() {
            loadData('dept');
        });

        $("#mode").one("click", function() {
            
            loadData('mode');

        });
    });

    //     var box = document.getElementById('box');
    // var down = false;

    // function toggleNotifi(){
    //     if(down){
    //         box.style.height = '0px';
    //         box.style.opacity = '0';
    //         down = false;
    //     }
    //     else
    //         {
    //             box.style.height = 'auto';
    //             box.style.opacity = '1';
    //             down = true;
    //         }   
    // }
    // Notification Dropdown
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(e) {
        if (!e.target.matches('.dropbtn')) {
            var myDropdown = document.getElementById("myDropdown");
            if (myDropdown.classList.contains('show')) {
                myDropdown.classList.remove('show');
            }
        }
    }

    function myFunction() {
        var x = document.getElementById("myDIV");
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
    }
</script>
</body>

</html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Electoral Role Search</title>
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <div id="container_role">
            <div id="title">
                Electoral Role Search
            </div>

            <form id="role_information" action="middle.php" method="post">
                <div class="name"><h>Full Name</h></div>
                <div class="input">
                    <input id="fname" name="fname" placeholder="Enter your full name here" type="text" required class="validate" autocomplete="off">
                </div>

                <div class="clearfix"></div>

                <div class="name"><h>Address</h></div>
                <div class="input">
                    <input id="address" name="address" placeholder="Search address here..." type="text" required class="validate" autocomplete="off">
                </div>

                <div class="clearfix"></div>

                <div class="name"><h>Appartment Suite, etc(optional)</h></div>
                <div class="input">
                    <input id="asuite" name="asuite" placeholder="Search appartment suite here..." type="text" required class="validate" autocomplete="off">
                </div>

                <div class="clearfix"></div>

                <div class="name"><h>Suburb</h></div>
                <div class="input">
                    <input id="suburb" name="suburb" placeholder="Search suburb here..." type="text" required class="validate" autocomplete="off">
                </div>

                <div class="clearfix"></div>

                <div class="name"><h>State</h></div>
                <div class="input">
                    <input id="state" name="state" placeholder="Search state here..." type="text" required class="validate" autocomplete="off">
                </div>

                <div class="clearfix"></div>
                
                <div class="name"><h>Postcode</h></div>
                <div class="input">
                    <input id="postcode" name="postcode" placeholder="Enter postcode here..." type="text" required class="validate" autocomplete="off">
                </div>

                <div class="have-voted">
                    <input type="checkbox" id="voted">
                    <span style="color: #DDD">Have you voted before in THIS election? (Tick if already voted)</span>
                </div>

                <button type="submit" id="next">NEXT</button>
            </form>
        </div>

        <script>
            (function() {
                var widget, initAddressFinder = function() {
                    widget = new AddressFinder.Widget(
                        document.getElementById('address'),
                        'ADDRESSFINDER_DEMO_KEY',
                        'AU', {
                            "address_params": {
                                "gnaf": "1"
                            }
                        }
                    );

                    widget.on('address:select', function(fullAddress, metaData) {
                        // TODO - You will need to update these ids to match those in your form
                        document.getElementById('asuite').value = metaData.address_line_1;
                        document.getElementById('address').value = metaData.address_line_2;
                        document.getElementById('suburb').value = metaData.locality_name;
                        document.getElementById('state').value = metaData.state_territory;
                        document.getElementById('postcode').value = metaData.postcode;

                    });
                };

                function downloadAddressFinder() {
                    var script = document.createElement('script');
                    script.src = 'https://api.addressfinder.io/assets/v3/widget.js';
                    script.async = true;
                    script.onload = initAddressFinder;
                    document.body.appendChild(script);
                };

                document.addEventListener('DOMContentLoaded', downloadAddressFinder);
            })();

            document.getElementById("next").addEventListener("click", jumpToBallot);

            function jumpToBallot() {
                if(document.getElementById("voted").checked){
                    alert ("You are already voted!");
                } else {
                    location.href="middle.php";
                }
            }
        </script>
    </body>
</html>
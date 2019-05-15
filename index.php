<?php
/*
 * Originally Coded by clone1018 [?]
 * Changes made by me include: Hosts added, HTML improved for my needs, additional CSS added
 * Final Version 1.0 Went live on 14.05.2019
 */
$title = "status ndmts"; // website's title
$servers = array(
    'NextCloud Service' => array(
        'ip' => 'attikacloud.ddns.net',
        'port' => 443,
        'info' => 'NextCloud Cloudservice',
        'purpose' => 'Filestorage'
    ),
    'TeamSpeak3 Server' => array(
        'ip' => '81.221.216.103',
        'port' => 30033,
        'info' => 'TeamSpeak3 Server',
        'purpose' => 'TeamSpeak3 Server'
    ),
    'Status Page' => array(
        'ip' => 'ndm-ts.ch',
        'port' => 443,
        'info' => 'Status Page',
        'purpose' => 'status page for the services im hosting'
    )
);
if (isset($_GET['host'])) {
    $host = $_GET['host'];
    if (isset($servers[$host])) {
        header('Content-Type: application/json');
        $return = array(
            'status' => test($servers[$host])
        );
        echo json_encode($return);
        exit;
    } else {
        header("HTTP/1.1 404 Not Found");
    }
}
$names = array();
foreach ($servers as $name => $info) {
    $names[$name] = md5($name);
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/2.3.2/cosmo/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
    <nav class="topnav" id="myTopnav">
        <a href="https://attikacloud.ddns.net" class="text">NextCloud</a>
        <a href="./monitor" class="text">Status Login</a>
        <a href="ts3server://81.221.216.103" class="text">Connect to Server</a>
        <a href="/contact.php" class="text">Report Incident</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
        <script>
            function myFunction() {
                var x = document.getElementById("myTopnav");
                if (x.className === "topnav") {
                    x.className += " responsive";
                } else {
                   x.className = "topnav";
                }
            } 
        </script>
    </nav>
        <div class="container">
            <h1 class="text"><?php echo $title; ?></h1>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text">Name</th>
                        <th class="text">Host</th>
                        <th class="text">Purpose</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($servers as $name => $server): ?>

                        <tr id="<?php echo md5($name); ?>">
                            <td><i class="icon-spinner icon-spin icon-large"></i></td>
                            <td class="name" class="text"><?php echo $name; ?></td>
                            <td class="text"><?php echo $server['info']; ?></td>
                            <td class="text"><?php echo $server['purpose']; ?></td>
                        </tr>

                    <?php endforeach; ?>
                
                </tbody>
            </table>
            <footer>
                <p class="text">To report an incident either contact an Admin or write a Mail to <a href="mailto:nils.marti@ndm-ts.ch">me</a>(nils.marti@ndm-ts.ch)</p>
            </footer>    
        </div>

        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript">
            function test(host, hash) {
                // Fork it
                var request;
                // fire off the request to /form.php
                request = $.ajax({
                    url: "<?php echo basename(__FILE__); ?>",
                    type: "get",
                    data: {
                        host: host
                    },
                    beforeSend: function () {
                        $('#' + hash).children().children().css({'visibility': 'visible'});
                    }
                });
                // callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR) {
                    var status = response.status;
                    var statusClass;
                    if (status) {
                        statusClass = 'success';
                    } else {
                        statusClass = 'error';
                    }
                    $('#' + hash).removeClass('success error').addClass(statusClass);
                });
                // callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown) {
                    // log the error to the console
                    console.error(
                        "The following error occured: " +
                            textStatus, errorThrown
                    );
                });
                request.always(function () {
                    $('#' + hash).children().children().css({'visibility': 'hidden'});
                })
            }
            $(document).ready(function () {
                var servers = <?php echo json_encode($names); ?>;
                var server, hash;
                for (var key in servers) {
                    server = key;
                    hash = servers[key];
                    test(server, hash);
                    (function loop(server, hash) {
                        setTimeout(function () {
                            test(server, hash);
                            loop(server, hash);
                        }, 6000);
                    })(server, hash);
                }
            });
        </script>

    </body>
</html>
<?php
/* Misc at the bottom */
function test($server) {
    $socket = @fsockopen($server['ip'], $server['port'], $errorNo, $errorStr, 3);
    if ($errorNo == 0) {
        return true;
    } else {
        return false;
    }
}
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}
?>
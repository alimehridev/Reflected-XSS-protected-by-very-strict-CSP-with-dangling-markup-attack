<?php
    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['login_status'])){
        if($_SESSION['login_status'] == true){
            header("Location: /my-account.php");
        }
    }
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    $csrf = $_SESSION['csrf'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "portswigger-db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_POST['username']) && isset($_POST['password'])){
        $csrf_token = $_POST['csrf'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($_SESSION['csrf'] != $csrf_token){
            header("Location: /login.php");
            $_SESSION['error_message'] = "Wrong CSRF Token.";
        }

        $sql = "SELECT username, email FROM users WHERE username='" . $username . "' AND password='" . $password . "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username;
            $_SESSION['login_status'] = true;
            $_SESSION['error_message'] = "";
            while($row = $result->fetch_assoc()) {
                $email = $row['email'];
                $_SESSION['email'] = $email;
            }
            header("Location: /my-account.php");
            $_SESSION['error_message'] = "";
        } else {
            header("Location: /login.php");
            $_SESSION['error_message'] = "Username or password is wrong.";
        }
        $conn->close();
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <link href=resources/labheader/css/academyLabHeader.css rel=stylesheet>
        <link href=resources/css/labs.css rel=stylesheet>
        <title>Reflected XSS protected by very strict CSP, with dangling markup attack</title>
    </head>
    <body>
        <script src="resources/labheader/js/labHeader.js"></script>
        <div id="academyLabHeader">
            <section class='academyLabBanner'>
                <div class=container>
                    <div class=logo></div>
                        <div class=title-container>
                            <h2>Reflected XSS protected by very strict CSP, with dangling markup attack</h2>
                            <a id='exploit-link' class='button' target='_blank' href='https://exploit-0aba00b6038b921c805a0249010200d7.exploit-server.net'>Go to exploit server</a>
                            <a class=link-back href='https://portswigger.net/web-security/cross-site-scripting/content-security-policy/lab-very-strict-csp-with-dangling-markup-attack'>
                                Back&nbsp;to&nbsp;lab&nbsp;description&nbsp;
                                <svg version=1.1 id=Layer_1 xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x=0px y=0px viewBox='0 0 28 30' enable-background='new 0 0 28 30' xml:space=preserve title=back-arrow>
                                    <g>
                                        <polygon points='1.4,0 0,1.2 12.6,15 0,28.8 1.4,30 15.1,15'></polygon>
                                        <polygon points='14.3,0 12.9,1.2 25.6,15 12.9,28.8 14.3,30 28,15'></polygon>
                                    </g>
                                </svg>
                            </a>
                        </div>
                        <div class='widgetcontainer-lab-status is-notsolved'>
                            <span>LAB</span>
                            <p>Not solved</p>
                            <span class=lab-status-icon></span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div theme="">
            <section class="maincontainer">
                <div class="container is-page">
                    <header class="navigation-header">
                        <section class="top-links">
                            <a href=/>Home</a><p>|</p>
                            <a href="/my-account">My account</a><p>|</p>
                        </section>
                    </header>
                    <header class="notification-header">
                    </header>
                    <h1>Login</h1>
                    <section>
                        <form class=login-form method=POST action="/login">
                            <input required type="hidden" name="csrf" value="<?php echo $csrf; ?>">
                            <label>Username</label>
                            <input required type=username name="username" autofocus>
                            <label>Password</label>
                            <input required type=password name="password">
                            <button class=button type=submit> Log in </button>
                            <span style="color: red"><?php if (isset($_SESSION['error_message'])) { echo $_SESSION['error_message']; } ?></span>
                        </form>
                    </section>
                </div>
            </section>
            <div class="footer-wrapper">
            </div>
        </div>
    </body>
</html>

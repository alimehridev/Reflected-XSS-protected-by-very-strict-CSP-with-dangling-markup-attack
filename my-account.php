<?php
    session_start();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    $csrf = $_SESSION['csrf'];
    if(!isset($_SESSION['username'])){
        header("Location: /login.php");
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
                            <a href="/">Home</a><p>|</p>
                            <a href="/my-account.php">My account</a><p>|</p>
                            <a href="/logout.php">Log out</a><p>|</p>
                        </section>
                    </header>
                    <header class="notification-header">
                    </header>
                    <h1>My Account</h1>
                    <div id=account-content>
                        <p>Your username is: <?php echo $_SESSION['username'] ?></p>
                        <p>Your email is: <span id="user-email"><?php echo $_SESSION['email']; ?></span></p>
                        <form class="login-form" name="change-email-form" action="change-email.php" method="POST">
                            <label>Email</label>
                            <input required type="email" name="email" value="<?php if(isset($_GET['email'])){ echo $_GET['email']; } ?>">
                            <input required type="hidden" name="csrf" value="<?php echo $csrf; ?>">
                            <button class='button' type='submit'> Update email </button>
                            <br>
                            <span style="color: red"><?php if (isset($_SESSION['error_message'])) { echo $_SESSION['error_message']; } ?></span>
                            <br>
                            <span style="color: green"><?php if (isset($_SESSION['success_message'])) { echo $_SESSION['success_message']; } ?></span>
                            <br>
                        </form>
                    </div>
                </div>
            </section>
            <div class="footer-wrapper">
            </div>
        </div>
    </body>
</html>

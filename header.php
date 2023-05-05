

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" contents="CSE 442 Web App">
        <link rel="stylesheet" href="css/styleDark.css" type="text/css">
        <?php 
            $theme = "";
           	setcookie("themeChoice","$theme","3600*7");
        ?>
    </head>
    <body>
        <header>
            <nav id="navigation">
                <ul>
                    <li class="group"><span>the fellas.</span></li>
                    <li>
                        <ul class="nav-options">
                            <li><select id="themeListDrop" name="themeListDrop">
                                <option><li><a href="themeSet.php?choice=styleDark">Dark</a></option>
                                <option><li><a href="themeSet.php?choice=styleColor">Color</a></option>
                                <option value="Light">Light</option></select></li>                 
                            <li><a href="index.php" class="current">Home</a></li>
                            <li><a href="editProfile.php">Profile</a></li>
                            <li><a href="logOut.php">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        <div id="contents">
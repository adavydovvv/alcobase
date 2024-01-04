<header>
    <nav>
        <ul>
            <li>
                <a href="<?php
                $name = 'Главная';
                $link = 'index.php';
                $current_page = true;

                echo $link;

                ?>">
                <?php
                if ($current_page_home) {
                    echo '<span class="selected_menu">' . $name . '</span>';
                } else {
                    echo $name;
                }
                ?>
                </a>
            </li> 
        </ul>
    </nav>
</header>

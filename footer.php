<footer>
    <div class="wrapper wrapper--footer">

        <nav>
            <a class="nav-item" href="<?php echo isset($thankyou) ? '../index.php' : 'index.php'; ?>">Home</a>
            <a class="nav-item" href="<?php echo isset($thankyou) ? '../blog' : 'blog'; ?>">Blog</a>
            <a class="nav-item" href="<?php echo isset($thankyou) ? '../blog/about-us' : 'blog/about-us'; ?>">About Us</a>
            <a class="nav-item" href="<?php echo isset($thankyou) ? '../blog/contact' : 'blog/contact'; ?>">Contact</a>
        </nav>

        <div class="copyrights">Copyrights &copy; <?php echo date('Y')  . ' ' . $row['site_title']; ?>.</div>

    </div>
</footer>

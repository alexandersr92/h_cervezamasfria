<?php
$logo = get_field('logo', 'option');
$rrss = get_field('rrss', 'option');
?>

<footer class="bg-transparent -mt-[250px]">
    <div class="bgFooterDeco h-32 md:h-64 w-screen"></div>
    <div class="container pb-[60px] flex flex-col items-center gap-10 bg-white">
        <img src="<?= $logo['url'] ?>" alt="<?= $logo['alt'] ?>">
        <div class="flex flex-row items-center gap-8">
            <?php
            foreach ($rrss as $rs) {

            ?>
                <a href="<?= $rs['link']['url'] ?>" target="_blank"><img class="w-10 h-10" src="<?= $rs['icon']['url'] ?>"></a>
            <?php
            }
            ?>
        </div>
    </div>
</footer>



<?php wp_footer() ?>
</body>

</html>
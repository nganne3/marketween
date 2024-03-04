<?php

    $classT1 = "";
    $classT2 = "";
    $classT3 = "";

    if (isset($_GET['explorepage'])) {
        $laycainit = $_GET['explorepage'];
        if ($laycainit == "exploreUsers") {
            $classT1 = "color:gray;";
            $classT2 = "color:gray;";
            $classT3 = "color:black;";
        }
        elseif($laycainit == "exploreProducts"){
            $classT1 = "color:gray;";
            $classT2 = "color:black;";
            $classT3 = "color:gray;";
        }
        else{
            $classT1 = "color:black;";
            $classT2 = "color:gray;";
            $classT3 = "color:gray;";
        }
    } else {           
        $laycainit = "";
        $classT1 = "color:black;";
        $classT2 = "color:gray;";
        $classT3 = "color:gray;";
    }

?>

<div id="explore_page" style="margin-bottom: 100px;">
    <div class="container_duythai container_responsive">
        <div class="menu_ul_duythai">
            <div class="menu_duythai menu_responsive_duythai">
                <ul>
                    <li class="menu-li_duythai menu_li_responsive_duythai"><a style="<?php echo $classT1; ?>" class="xam-or-black-explore" href="index.php?act=explore&explorepage=exploreCollections">Bộ sưu tập</a></li>
                    <li class="menu-li_duythai menu_li_responsive_duythai"><a style="<?php echo $classT2; ?>" class="xam-or-black-explore" href="index.php?act=explore&explorepage=exploreProducts">Sản phẩm</a></li>
                    <li class="menu-li_duythai menu_li_responsive_duythai"><a style="<?php echo $classT3; ?>" class="xam-or-black-explore" href="index.php?act=explore&explorepage=exploreUsers">Người dùng</a></li>
                </ul>
            </div>
        </div>
        
        <div>

        <!-- ======================================================CHANGE============================================== -->

        <?php
            if (isset($_GET['explorepage'])) {
                $page = $_GET['explorepage'];
                if ($page == 'exploreCollections' || $page == 'exploreProducts' || $page == 'exploreUsers' ) {
                    renderView($page);         
                }
                else {
                    renderView("exploreCollections");
                }
            } else {           
                $page = "";
                renderView("exploreCollections");
            }
        ?>

        </div>
    </div>
</div>

<script src="<?php echo SITE_SCRIPT_PATH; ?>explore_product_url.js"></script>
<script src="<?php echo SITE_SCRIPT_PATH; ?>ft_collections_explore.js"></script>
<script>
    $(document).on('click', '#dwon_band', function() {
        // console.log('alo');
        const downex = document.getElementById('myDropdownexplore');

        let vanva = getComputedStyle(downex);

        if (vanva.display == "none") {
            downex.style.display = "block";
        }
        else{
            downex.style.display = "none";
        }
    });

</script>

</body>
</html>
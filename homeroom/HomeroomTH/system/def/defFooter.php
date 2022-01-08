<div style="padding-top: 100px;"></div>

<div class="container-fluid container-fixed-lg footer">
    <div class="copyright sm-text-center">
        <p class="small no-margin pull-left sm-pull-reset">
            <span class="font-montserrat">
                <a class="brand" href=<?php echo "\"". Config::sysMakerSite ."\""; ?> target="_blank" ><?php echo Config::sysMaker; ?></a>
            </span>
        </p>
        <p class="small no-margin pull-right sm-pull-reset">
            <?php
            $data = getrusage();  
            $usertime = ($data['ru_utime.tv_sec'] +  $data['ru_utime.tv_usec'] / 1000000);  
            $systemtime = ($data['ru_stime.tv_sec'] +  $data['ru_stime.tv_usec'] / 1000000); 
            ?>

            <span class="hint-text">
                Code licensed <i class="glyphicon glyphicon-copyright-mark"></i> under : Apache License v2.0, User:[<?php echo number_format($usertime, 3, '.', '');?>] | Server:[<?php echo number_format($systemtime, 3, '.', '');?>]
            </span>
        </p>
        <div class="clearfix"></div>
    </div>
</div>

<!-- END TAG FROM defHeader.php -->
</div>
<!-- END CONTAINER FLUID -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTAINER -->

</body>
</html>
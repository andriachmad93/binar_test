<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php if($this->uri->segment(1)!='home'){ echo $controller_name.' - '; } echo $function_name; ?> | Indonesia Berzakat </title>
    <base href="<?php echo base_url() ?>"></base>
	<link rel="icon" href="assets/uploads/app_settings/5774f75817843-original.png" type="image/x-icon" />
   <!--Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Karla:400,400italic,700italic,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
    
    <!--Bootstrap-->
    <link rel="stylesheet" href="assets/frontend_assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/frontend_assets/css/bootstrap-theme.min.css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="assets/frontend_assets/css/font-awesome.min.css">
    <!--Owl Carousel-->
    <link rel="stylesheet" href="assets/frontend_assets/vendors/owl.carousel/owl.carousel.css">
    <!--Magnific Popup-->
    <link rel="stylesheet" href="assets/frontend_assets/vendors/magnific-popup/magnific-popup.css">
    
    <!--Theme Styles-->
    <link rel="stylesheet" href="assets/frontend_assets/css/style.css">
    <link rel="stylesheet" href="assets/frontend_assets/css/theme.css">
    <link rel="stylesheet" href="assets/frontend_assets/css/datepicker.css">
    <link rel="stylesheet" href="assets/frontend_assets/css/donation.css">
    
    <!--[if lt IE 9]>
        
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
    
</head><!--/head-->

<body>
 <header class="green-back">
        <div class="container">
		<div class="pull-left"><a class="navbar-brand" href="#"><img src="assets/frontend_assets/images/si_logo.png" width="170px" style="margin-top:5px; margin-bottom:10px;" alt=""></a></div>
            <div class="pull-right emergency-contact">
                <div class="pull-left">
                    <span class="col-white"><i class="fa fa-envelope-o"></i></span>
                    <div class="infos_col">
                        <h6 class="col-white">email kami di</h6>
                        <a href="mailto:info@indonesiaberzakat.org"><h5 class="col-white">info@indonesiaberzakat.org</h5></a>
                    </div>
                </div>
                
                <div class="pull-left link-log">
                    <?php
                    if($this->session->userdata('validated')){?>
                       <a href="dashboard"><h7 >Hello, <?php echo $this->session->userdata('firstname');?></h7></a>
                                        </div>
                                        <div class="pull-left link-log">
                    
                        <a href="login/logout"><h7>Logout</h7></a>

                        <?php
                        }else{
                     ?>
                        <a href="login"><h7 >Masuk</h7></a>
                                        </div>
                                        <div class="pull-left link-log">
                    
                        <a href="register"><h7>Daftar</h7></a>
                                        </div>
                                        <?php } ?>
                </div>
            </div>
        </div>        
    </header>
    <nav class="navbar navbar-default navbar-static-top top-n">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="assets/frontend_assets/images/logonya.png" alt=""></a>
            </div>            
            <div class="collapse navbar-collapse" id="mainNav">
                <a href="zakat" class="volunteer-link btn-primary btn-outline hidden-sm hidden-xs pull-right">Ayo Berzakat</a>
                <ul class="nav navbar-nav navbar-right">
                    <li <?php if($this->uri->segment(1)=='home' or $this->uri->segment(1)==''){ ?> class="active" <?php } ?>>
                        <a href="">Beranda</a>
                    </li>
                  <li class="hide-menu"> <a href="zakat">Ayo Berzakat</a></li>
                    <li <?php if($this->uri->segment(1)=='campaign'){ ?> class="active" <?php } ?>>
                        <a href="campaign" >Campaign</a>
                        <li <?php if($this->uri->segment(1)=='reguler'){ ?> class="active" <?php } ?>>
                        <a href="sedekah_produktif" >Sedekah Produktif</a>
                        
                    </li>
                   
                    <li <?php if($this->uri->segment(1)=='about'){ ?> class="active" <?php } ?>>
                        <a href="about" >Tentang Kami</a>
                        
                    </li>
                   
                    <li <?php if($this->uri->segment(1)=='contact'){ ?> class="active" <?php } ?>><a href="contact">Kontak Kami</a></li>
					<li class="hide-menu"> <?php if($this->session->userdata('validated')){?>  <a href="dashboard">Hello, <?php echo $this->session->userdata('firstname');?></a> <?php }else{ ?> <a href="login">Login</a> <?php } ?></li>
					<li class="hide-menu"> <?php if($this->session->userdata('validated')){?> <a href="login/logout">Logout</a>  <?php }else{?> <a href="register">Register</a> <?php } ?></li>
                </ul>                
            </div>
        </div>
    </nav>
    <?php if($this->uri->segment(1)=='home' or $this->uri->segment(1)=='' ){ ?>
    <div class="bar-bottom">
        
                <a id="donasi" href="campaign" class="btn-primary">donasi sekarang</a>
                <a id="zakat" href="zakat" class="btn-primary btn-outline">Ayo Berzakat</a>
            
    </div>
    <?php } ?>
    <?php echo $page; ?>
    
    <footer class="row footer">
        <div class="container">
            <div class="row footer_sidebar">
                <div class="widget widget-about col-sm-6 col-md-3">
                    <h6 class="label label-default widget-title">Tentang Kami</h6>
                    <p>Indonesia Berzakat adalah platform online (website, android app, ios app) terbaik untuk menunaikan zakat dan berdonasi secara online.</p>
                    <a href="about" class="btn-primary btn-outline">ketahui lebih lanjut</a>
                </div>
                <div class="widget widget-recent-posts col-sm-6 col-md-3">
                    <h6 class="label label-default widget-title">Berita Terakhir</h6>
                    <ul class="nav recent-posts">
                        <?php $news= $this->db->query("select * from si_article order by id desc limit 0,3")->result();
                        foreach ($news as $data) {
                        ?>
                        <li><a href="news/detail/<?php echo $data->id ?>/<?php echo str_replace(' ','-', $data->title) ?>"><?php echo $data->title ?></a></li>
                        <?php } ?>

                    </ul>
                </div>
                <div class="widget widget-recent-tweets col-sm-6 col-md-3">
                    <h6 class="label label-default widget-title">tweet terakhir</h6>
                    <div class="tweet m0">
                        <p><a href="#">@dennybasri</a>  Terima kasih Indonesia Berzakat telah membantu saya untuk berdonasi <br>
                        <span class="time_past">2 months ago</span></p>
                    </div>
                    <a href="#" class="btn-primary btn-outline">follow kami sekarang</a>
                </div>
                <div class="widget widget-contact col-sm-6 col-md-3">
                    <h6 class="label label-default widget-title">Kontak Kami</h6>
                    <address>
                        Jalan Pangeran Diponegoro No.43, Menteng, Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10310
                        <br><br>
                        <span>Telepon</span> : 0812-9616-0550 <br>
                        <span>Email</span> : <a href="mailto:info@indonesiaberzakat.org">info@indonesiaberzakat.org</a></br></br>
                        <strong><span>Rekening</span> : 0335.01.002122.30.2</br>
                        <span>A/N</span> : DPP SYARIKAT ISLAM QQ LAZ SI INDONESIA BERZAKAT BANK BRI
                        </br>CABANG KRAMAT</strong>
                    </address>
                </div>
            </div>
        </div>
        
        <div class="row copyright_area m0">
            <div class="container">
                <div class="copy_inner row">
                    <div class="col-sm-7 copyright_text">Copyright 2016. All Rights Reserved by Indonesia Berzakat.</div>
                    <div class="col-sm-5 footer-nav">
                        <ul class="nav">
                            <li><a href="#">Syarat dan Ketentuan</a></li>
                            <li><a href="#">Kebijakan Privasi</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/57be9d0f5982876b10bd0a9f/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<?php if($this->uri->segment(1)!='dashboard' and $this->uri->segment(2)!='create_campaign'){  ?>
<script src="assets/frontend_assets/js/jquery-2.1.4.min.js"></script>
<?php } ?>
<script src="assets/frontend_assets/js/moment.js"></script>
<script src="assets/frontend_assets/js/bootstrap-datepicker.js"></script>
<script src="assets/frontend_assets/js/bootstrap.min.js"></script>

<!--Magnific Popup-->
<script src="assets/frontend_assets/vendors/magnific-popup/jquery.magnific-popup.min.js"></script>
<!--Owl Carousel-->
<script src="assets/frontend_assets/vendors/owl.carousel/owl.carousel.min.js"></script>
<!--CounterUp-->
<script src="assets/frontend_assets/vendors/couterup/jquery.counterup.min.js"></script>
<!--WayPoints-->
<script src="assets/frontend_assets/vendors/waypoint/waypoints.min.js"></script>
<!--Theme Script-->    
<script src="assets/frontend_assets/js/theme.js"></script>
<!-- Jquery Money -->
<script src="assets/frontend_assets/js/jquery.maskMoney.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.money').maskMoney({precision:0});
});
</script>

</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="app/assets/images/favicon.png"/>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
<META NAME="Description" CONTENT="">
<title>Instituto Pindorama</title>

<style type="text/css">
body { 
	background-color: #fff;
	margin: 0;
}
.container{
	display: table;
	margin: 0 auto;
	position: relative;
	width: 1100px;
}
.header-pgto{
	background-color: #fff;
	border-top: 10px solid #f28c36;
	border-bottom: 10px solid #548964;
	height: 100px;
}
.header-pgto h1{
	float: left;
}
.header-pgto .logo img{
	margin: 0 0 0 0;
	width: 213px;
}
.header-pgto .telefones{
	float: left;
 	margin: 50px 0 0 0;
}
.header-pgto .telefones li{
	display: inline-block;
}
.header-pgto .telefones li a {
    color: #000;
    font-family: "Roboto";
    font-weight: bold;
    margin: 0 0 0 35px;
    text-decoration: none;
}
.error{
	margin-top: 4rem;
	width: 100%;
}
.error h2{
	color: #f28c36;
	font-family: "Roboto";
	font-size: 2rem;
	font-weight: normal;
	margin-bottom: 15px;
	text-transform: uppercase;
	width: 100%;
}
.error .info2{
	background-color: #335c3f;
	color: #000;
	display: table;
	margin-top: 1.5rem;
	padding: 2rem;
	width: 100%;
}
.error .info2 h4{
	color: #fff;
	font-family: "Roboto";
	font-size: 1.25rem;
	margin-bottom: 1.4rem;
}
.error .info2 ul li{
	color: #fff;
	font-family: "Roboto";
	font-size: 1rem;
	line-height: 25px;
	width: 100%;
}
.error button{
	background-color: #3B8C14;
    border: none;
    color: #fff;
    cursor: pointer;
    font-family: "Roboto";
	font-size: 1rem;
	font-weight: bold;
	left: 50%;
	margin: 30px 0 40px -115px;
	padding: 13px 30px;
	position: relative;
	text-transform: uppercase;
}
.third-footer{
	background-color: #335c3f;
	bottom: 0;
	display: table;
	position: absolute;
	width: 100%;
}
.third-footer address{
	color: #fff;
	float: left;
	font-style: normal;
}
.third-footer address p{
	color: #fff;
	font-family: "Roboto";
	font-size: 14px;
	line-height: 18px;
}
.third-footer .sistema {
	float: right;
}
.third-footer .sidec{
	background-image: url(/app/assets/images/logo-sidec-labs.png);
	display: inline-block;
	float: right;
	height: 30px;
	margin-top: 20px;
	margin-right: 30px;
	width: 122px;
}
.third-footer .dzaine{
	background-image: url(/app/assets/images/logo-dzaine.png);
	display: inline-block;
	float: right;
	height: 19px;
	margin-top: 25px;
	width: 80px;
}
@media only screen and (min-width: 641px) and (max-width: 1280px){
	.container{
		width: 800px;
	}
	.error .info2 {
		width: 93%;
	}
}
</style>

</head>
<body>

	<section class="header-pgto">
		<div class="container">
			<h1><a class="logo" href="/index"><img src="/app/assets/images/logo.png" alt="Instituto Pindorama"></a></h1>
			<!--info telefones-->
			<!-- <ul class="telefones">
				<li><a href="tel:+552225268429">(22) 2526-8429</a></li>
				<li><a href="tel:+5522996000019">(22) 99600-0019</a></li>
			</ul> -->
		</div>
	</section>

	<article class="error">
		<div class="container">
			<h2 class="titulo">Erro do Sistema</h2>
			<div class="info2">
				<ul>
					<li>Ops ocorreu um problema, contate o administrador do site ou tente novamente mais tarde!</li>
					<li>Agradecemos pela compreensão.</li>
				</ul>
			</div>
			<a href="/index"><button class="button success">Voltar para a home</button></a>
		</div>
	</article>

	<section class="third-footer">
		<div class="container">
			<!--razão social-->
		    <address>
				<p>Instituto Pindorama  |  CNPJ: 06.135.496/0001-97 <br>
				Nova Friburgo - RJ</p>
			</address>
			<!--selo dzaine-->
			<div class="sistema">
		    	<a href="http://www.dzaine.net" class="dzaine" target="_blank"></a>
		    	<a href="http://www.sideclabs.com.br/" class="sidec" target="_blank"></a>
		    </div>
		</div>
	</section>

</body>
</html>
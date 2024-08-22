<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	//print_r($images);die;
	$headerFont = $proposal->getClient()->getCompany()->getCoolHeaderFont();
	$bodyFont = $proposal->getClient()->getCompany()->getCoolTextFont();
	?>
	<meta charset="utf-8">
	<!--  This file has been downloaded from bootdey.com    @bootdey on twitter -->
	<!--  All snippets are MIT license http://bootdey.com/license -->
	<title>invoice order receipt - Bootdey.com</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo site_url('static') ?>/css/signature-pad.css">
	<link rel="stylesheet" href="<?php echo site_url('3rdparty/fontawesome/css/font-awesome.min.css') ?>">
	<style type="text/css">
		.doc-section{font-family:Lato, sans-serif, Sans-Serif !important}
		.closeProposalCarousel {
			position: absolute;
			right: 20px;
			top: 10px;
			font-size: 25px;
		}

		.closeProposalSignature {
			position: absolute;
			right: 5px;
			top: 5px;
			font-size: 22px;
		}

		.modal-dialog {
			max-width: 70%;
			height: 500px;
		}

		.company_name {
			font-size: 27px;
			line-height: 38px;
		}

		.company_owner {
			font-size: 19px;
			line-height: 28px;
		}

		.company_name,
		.company_owner {
			padding: 0;
			margin: 0;
		}

		body {

			background: #eee;
			position: relative;
			font-size: 13px;
			line-height: 1.1;
			color: #000;
		}

		.invoice {
			padding: 30px;
		}

		

		.invoice hr {
			margin-top: 10px;
			border-color: #ddd;
		}

		.invoice .table tr.line {
			border-bottom: 1px solid #ccc;
		}

		.invoice .table td {
			border: none;
		}

		.invoice .identity {
			margin-top: 10px;
			font-size: 1.1em;
			font-weight: 300;
		}

		.invoice .identity strong {
			font-weight: 600;
		}


		.grid {
			position: relative;
			width: 100%;
			background: #fff;
			/* color: #666666; */
			border-radius: 2px;
			margin-bottom: 25px;
			box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1);
		}


		main {
			display: flex;
			flex-wrap: nowrap;
			height: 100vh;
			height: -webkit-fill-available;
			max-height: 100vh;
			overflow-x: auto;
			overflow-y: hidden;
		}

		.b-example-divider {
			flex-shrink: 0;
			width: 1.5rem;
			height: 100vh;
			background-color: rgba(0, 0, 0, .1);
			border: solid rgba(0, 0, 0, .15);
			border-width: 1px 0;
			box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
		}

		.bi {
			vertical-align: -.125em;
			pointer-events: none;
			fill: currentColor;
		}

		.dropdown-toggle {
			outline: 0;
		}

		.nav-flush .nav-link {
			border-radius: 0;
		}

		.btn-toggle {
			display: inline-flex;
			align-items: center;
			padding: .25rem .5rem;
			font-weight: 600;
			color: rgba(0, 0, 0, .65);
			background-color: transparent;
			border: 0;
			width: 100%;
		}

		.btn-toggle:hover,
		.btn-toggle:focus {
			color: #fff;
			background-color: #0d6efd;
		}

		.btn-toggle::before {
			width: 1.25em;
			line-height: 0;
			content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
			transition: transform .35s ease;
			transform-origin: .5em 50%;
		}

		.sep-link:hover,
		.sep-link:focus {
			color: #fff;
			background-color: #0d6efd;
		}

		.sep-link.active {
			color: #fff;
			background-color: #0d6efd;
		}

		.sep-link {
			display: inline-flex;
			/* align-items: center; */
			text-align: left;
			padding: .25rem .5rem;
			font-weight: 600;
			color: rgba(0, 0, 0, .65);
			background-color: transparent;
			border: 0;
			width: 100%;
		}

		.btn-toggle[aria-expanded="true"] {
			color: rgba(0, 0, 0, .85);
		}

		.btn-toggle[aria-expanded="true"]::before {
			transform: rotate(90deg);
		}

		.btn-toggle-nav a {
			display: inline-flex;
			padding: .1875rem .5rem;
			margin-top: .125rem;
			margin-left: 1.25rem;
			text-decoration: none;
		}

		.btn-toggle-nav a:hover,
		.btn-toggle-nav a:focus {
			background-color: #0d6efd;
		}

		.scrollarea {
			overflow-y: auto;
		}

		.fw-semibold {
			font-weight: 600;
		}

		.lh-tight {
			line-height: 1.25;
		}





		h1 {
			font-size: 24px;
			font-family: <?php echo $headerFont ?>, Sans-Serif !important;
			font-weight: bold;
			margin: 25.56px 0px;
		}

		h2 {
			font-size: 20px;
			font-family: <?php echo $headerFont ?>, sans-serif !important;
			font-weight: bold;
			margin: 25.56px 0px;
		}

		h3 {
			font-family: <?php echo $headerFont ?>, sans-serif !important;
			font-size: 17px;
			font-weight: bold;
			margin: 25.56px 0px;
		}

		h1.title_big {
			font-size: 38px;
			text-align: center;
			padding-top: 30mm;
			padding-bottom: 5mm;
			font-weight: bold;
		}

		.issuedby {
			width: 200px;
			line-height: 21px;
			text-align: center;

			right: 0;

		}

		.issuedby img {
			height: 60px;
			width: auto;
			margin-bottom: 7px;
		}

		.theLogo {

			width: 135px;
    		height: 45px;
		}

		h1.title_big2 {
			font-size: 34px;
			text-align: center;
			padding-bottom: 15mm;
			padding-top: 5px;
			margin: 0;
		}

		h1.title_big_aboutus {
			font-size: 34px;
			text-align: center;
			padding-bottom: 0;
			padding-top: 12mm;
		}
		.company_info_row p{
			margin-block-start: 1em;
    		margin-block-end: 1em;
		}

		.item-content-texts ol{
			margin-block-start: 1em;
    		margin-block-end: 1em;
		}
		.item-content h1, .item-content h2 {
			margin: 10px 0 0 0;
		}

		.global_header {
			height: 50px;
			font-size: 24px;
			width: 100%;
		}

		h1.underlined {
			border-bottom: 2px solid #000000;
			padding-bottom: 1mm;
			margin-bottom: 1mm;
		}

		.logotopright {
			width: 150px;
			height: 50px;
			position: absolute;
			right: 0px;
			top: 10px;
			text-align: right;
			z-index: 201;
		}

		.margin-top-bottom-10 {
			margin: 20px 0px 20px 0px
		}

		.sticky-sidebar2 {
			position: sticky;
			top: 0px;
			min-height: 800px;

		}

		.sticky-sidebar {
			width: 100%;
			height: 100vh;
			min-height: 200px;
			overflow-y: auto;
			overflow-x: hidden;
			position: sticky;
			top: 0;
		}


		.scrollbar-primary::-webkit-scrollbar {
			width: 8px;
			background-color: #F5F5F5;
		}

		.scrollbar-primary::-webkit-scrollbar-thumb {
			border-radius: 10px;
			-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
			background-color: #4285F4;
		}


		.mg-btm-20 {
			margin-bottom: 20px;
		}



		#gallery img {
			height: 75vw;
			-o-object-fit: cover;
			object-fit: cover;
		}

		@media (min-width: 576px) {
			#gallery img {
				height: 35vw;
			}
		}

		@media (min-width: 992px) {
			#gallery img {
				height: 18vw;
			}
		}

		.carousel-control-prev-icon {
			background-color: #6d6a6a9c;
		}

		.carousel-control-next-icon {
			background-color: #6d6a6a9c;
		}

		.pd-top-25 {
			padding-top: 25px
		}

		.pd-top-0-minus {
			padding-top: 0px;
			top: -5px
		}

		.carousel-caption {
			color: #000;
		}

		.bottom-note {
			bottom: 0;
			padding: 0px;
			position: sticky;
			;
		}

		.carousel-caption p {
			margin: 0px !important
		}

		.modal-body {
			padding-bottom: 2px;
		}

		.doc-section li {
			margin-bottom: 5px;
		}

		.sidebar-close {
			position: absolute;
			top: 10px;
			right: 20px;
		}

		.hide-sidebar {
			width: 0 !important
		}

		.hide-sidebar .p-3 {
			padding: 0 !important
		}

		.openbtn {
			font-size: 20px;
			cursor: pointer;
			color: black;
			position: fixed;
			width: 100px;
			top: 20px;
			display: none;
			z-index: 9;
		}

		#save_signature_loader {
			position: relative;
			margin-left: 5px;
			display: none;
		}
		.spinner-text{margin-left:10px;}

		.carousel-control-next,
		.carousel-control-prev {
			width: 50px
		}

		.carousel-control-next:hover,
		.carousel-control-prev:hover {
			background-color: #00000061
		}

		#proposalCarousel {
			margin-top: 15px;
		}

		.signature-pad {
			max-height: 277px;
			padding: 10px;
		}
		.signature-pad--footer{
			margin-top: 5px;
		}
		.signature-pad--actions{
			margin-top: 4px;
		}

		.proposalSignature label {
			font-weight: bold
		}

		.embed-responsive-item {
			min-height: 550px;
			width: 100%
		}

		.redhide{
			font-size: .875em;
    		color: #dc3545;
			display:none;
		}
		.offcanvas-end {
			width: 95%;
			
		}
		.offcanvas-header{
			padding: 1rem 1rem 0rem 1rem;
		}
		#my_pad{
			height: 286px;
			margin-top: 5px;
		}
	</style>
</head>

<body>
	<?php
	$s = array('$', ',');
	$r = array('', '');
	?>
	<div class="container-fluid">
		<div class="row">

			<nav class="col-md-3 nav " id="navbar-example3">
				<div class="flex-shrink-0 p-3 bg-white sticky-sidebar scrollbar-primary">
					<a href="#" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">

						<span class="fs-5 fw-semibold">Proposal Links</span>

					</a>

					<button type="button" class="btn sidebar-close" aria-label="Close"><i class="fa fa-chevron-circle-left"></i></button>
					<ul class="list-unstyled ps-0">
						<li class="mb-1"><a href="#title-page" class="btn sep-link align-items-center rounded">Cover Page</a></li>
						<li class="mb-1"><a href="#service-provider" class="btn sep-link align-items-center rounded">Service Provider</a></li>
						<li class="mb-1"><a href="#about-us-page" class="btn sep-link align-items-center rounded">About Us</a></li>
						<li class="mb-1 ">
							<button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
								Services
							</button>
							<div class="collapse show" id="home-collapse">
								<ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
									<?php foreach ($services as $service) { ?>
										<li><a href="#service_<?= $service->getServiceId(); ?>" class="btn sep-link rounded"><?php echo $service->getServiceName() ?></a></li>
									<?php } ?>

								</ul>
							</div>
						</li>
						<?php if (count($images)) { ?>					
							<li class="mb-1"><a href="#images" class="image_section_btn btn sep-link align-items-center rounded">Images</a></li>

						<?php
							}

						if ($proposal->getVideoURL() <> '') {
						?>

							<li class="mb-1"><a href="#video" class="video_section_btn btn sep-link align-items-center rounded">Video</a></li>
						<?php } ?>
						<li class="mb-1"><a href="#price-breakdown" class="btn sep-link align-items-center rounded">Price Breakdown</a></li>
						<li class="mb-1"><a href="#signature" class="btn sep-link align-items-center rounded">Signature</a></li>

						<?php
						$havetexts = false;
						//Custom texts
						//$cats = $this->em->createQuery('SELECT c FROM models\Customtext_categories c  where (c.company=' . $proposal->getClient()->getCompany()->getCompanyId() . ' or c.company=0)')->getResult();
						$cats = $this->customtexts->getCategories($proposal->getClient()->getCompany()->getCompanyId());
						$categories = array();
						$havetexts = false;
						$proposal_categories = $proposal->getTextsCategories();
						foreach ($cats as $cat) {
							if (@$proposal_categories[$cat->getCategoryId()]) {
								$categories[$cat->getCategoryId()] = array('name' => $cat->getCategoryName(), 'texts' => array());
							}
						}
						$texts = $this->customtexts->getTexts($proposal->getClient()->getCompany()->getCompanyId());
						$proposal_texts = $proposal->getTexts();
						foreach ($texts as $textId => $text) {
							if ((in_array($textId, $proposal_texts)) && (isset($categories[$text->getCategory()]))) {
								$havetexts = true;
								$categories[$text->getCategory()]['texts'][] = $text->getText();
							}
						} ?>





						<?php
						if ($havetexts) { ?>
							<li class="mb-1 ">
								<button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#term-collapse" aria-expanded="false">
									Term & Conditions
								</button>

								<div class="collapse " id="term-collapse">
									<ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
										<?php
										foreach ($proposal_categories as $catId => $on) {
											if ($on && isset($categories[$catId])) {
												$cat = $categories[$catId];
												if (count($cat['texts'])) {
										?>

													<li><a href="#custom_text_<?= $catId; ?>" class="btn sep-link rounded"><?php echo $cat['name'] ?></a></li>

										<?php
												}
											}
										} ?>


									</ul>
								</div>
							</li>
						<?php } ?>




						<?php
						//Attachments page
						$attachments = $proposal->getAttatchments();
						if (count($attachments) || count($proposal_attachments)) { ?>
							<!-- BEGIN INVOICE -->

							<li class="mb-1 ">
								<button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#attachment-collapse" aria-expanded="false">
									Attachments
								</button>

								<div class="collapse " id="attachment-collapse">
									<ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
										<?php
										if (count($attachments)) {
										?>

											<?php
											foreach ($attachments as $attachment) {
												$url = site_url('attachments/' . $proposal->getClient()->getCompany()->getCompanyId()) . '/' . $attachment->getFilePath();
											?>
												<li><a href="<?php echo str_replace(' ', '%20', $url) ?>" class="btn sep-link rounded"><?php echo $attachment->getFileName() ?></a></li>

											<?php
											}
										}
										if (count($proposal_attachments)) {
											?>

											<?php
											foreach ($proposal_attachments as $attachment) {
												$url = site_url('uploads/companies/' . $proposal->getClient()->getCompany()->getCompanyId() . '/proposals/' . $proposal->getProposalId() . '/' . $attachment->getFilePath());
											?>
												<li><a href="<?php echo str_replace(' ', '%20', $url) ?>" class="btn sep-link rounded"><?php echo $attachment->getFileName() ?></a></li>
										<?php
											}
										} ?>

									</ul>
								</div>
							</li>
						<?php
						} ?>







					</ul>
				</div>


			</nav>
			<span class="openbtn">☰</span>
			<!-- BEGIN INVOICE -->
			<div class="col-md-9 doc-section" style="min-height: 297mm;margin-top:15px">
				<div class="grid invoice">
					<div class="grid-body">
						<div class="invoice-title" id="title-page">
							<div class="row">

								<div class="col-md-12">
									<h1 class="title_big"><?php echo $proposal->getProposalTitle() ?></h1>
								</div>
							</div>
							<br>
							<div class="row" style="padding-bottom: 35mm;">
								<div class="col-md-12">
									<img src="<?php echo site_url('uploads/separator.jpg'); ?>" width="100%">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<?php if ($proposal->getClient()->getClientAccount()->getName()) { ?>
										<h2 class="company_name" style="text-align: center;"><?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName();  ?></h2>
									<?php } ?>
									<h3 class="company_owner" style="text-align: center; padding-bottom: 100px;"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName()  ?></h3>

									<h3 class="company_owner" style="text-align: center; font-size: 15px !important; line-height: 17px; margin-bottom: 15px;">Project:</h3>

									<h3 class="company_owner" style="text-align: center; margin-bottom: 0; padding-bottom: 0; line-height: 22px;"><?php echo $proposal->getProjectName()  ?></h3>
									<?php if ($proposal->getProjectAddress()) { ?>
										<h4 style="text-align: center; margin-top: 0; padding-top: 0; font-weight: normal; font-size: 13px;"><?php echo $proposal->getProjectAddress() ?><br><?php echo $proposal->getProjectCity() . ', ' . $proposal->getProjectState() . ' ' . $proposal->getProjectZip() ?></h4>
									<?php } ?>
								</div>
							</div>

							<div class="row">
								<div class="col-md-2 offset-md-9">
									<div class="issuedby">
										<p class="clearfix" style="line-height: 16px;">
											<img class="" src="<?php echo site_url('uploads/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo()); ?>" alt=""><br>
											<?php echo $proposal->getOwner()->getFullName() ?><br>
											<?php echo $proposal->getOwner()->getTitle() ?>
										</p>
									</div>
								</div>
							</div>

						</div>



					</div>
				</div>
				<!-- END INVOICE -->
				<!-- BEGIN INVOICE -->

				<div class="grid invoice">
					<div>

						<div class="row" id="service-provider">
							<div class="col-md-12">
								<h1 class="title_big2" style="z-index: 200;text-align:center"><?php echo $proposal->getClient()->getCompany()->getPdfHeader() ?></h1>
							</div>
						</div>
						<br>
						<div class="row company_info_row">
							<div class="col-md-6" style="text-align:center">
								<h2>Company Info</h2>
									<img class="theLogo" src="<?php echo site_url('uploads/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo()) ?>" alt="">
									<p><?php echo $proposal->getClient()->getCompany()->getCompanyName() ?><br>
										<?php echo $proposal->getOwner()->getAddress() ?><br>
										<?php echo $proposal->getOwner()->getCity() ?>, <?php echo $proposal->getOwner()->getState() ?> <?php echo $proposal->getOwner()->getZip() ?><br>
										<br>
										P: <?php echo $proposal->getOwner()->getOfficePhone() ?><br>
										<?php if ($proposal->getClient()->getCompany()->getFax() || $proposal->getOwner()->getFax()) { ?>
											F: <?php echo ($proposal->getOwner()->getFax()) ? $proposal->getOwner()->getFax() : $proposal->getClient()->getCompany()->getFax() ?><br>
										<?php } ?>
										<a href="<?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?>"><?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?></a><br>
									</p>
							</div>
							<div class="col-md-6" style="text-align:center">
								<h2>Contact Person</h2>
									<p style="padding-top: 0; margin-top: 0;"><?php echo $proposal->getOwner()->getFullName() ?><br>
										<?php echo $proposal->getOwner()->getTitle() ?><br>
										<a href="mailto:<?php echo $proposal->getOwner()->getEmail() ?>"><?php echo $proposal->getOwner()->getEmail() ?></a><br>
										Cell: <?php echo $proposal->getOwner()->getCellPhone() ?><br />
										Office <?php echo $proposal->getOwner()->getOfficePhoneExt() ? $proposal->getOwner()->getOfficePhone() . ' Ext ' . $proposal->getOwner()->getOfficePhoneExt() : $proposal->getOwner()->getOfficePhone(); ?>
									</p>
							</div>
						</div>

					</div>
				</div>
				<div class="grid invoice" style="padding-top: 10px;">
					<div class="grid-body">

						<div class="row" id="about-us-page">
							<h1 class="title_big_aboutus">About Us</h1>

							<p class="aboutus"><?php echo $proposal->getClient()->getCompany()->getAboutCompany() ?></p>
						</div>

					</div>
				</div>

				<!-- END INVOICE -->
				<!-- BEGIN INVOICE -->

				<div class="grid invoice" style="padding-top: 10px;">
					<div class="grid-body">

						<div class="row">
							<?php


							if ($proposal->getAuditKey()) {
							?>
								<div style="page-break-inside: avoid">
									<div class="item-content audit">
										<h2>Property Inspection / Audit</h2>

										<table>
											<tr>
												<td style="text-align: center">
													<a href="<?php echo $proposal->getAuditReportUrl(true) ?>" target="_blank" style="display: block">
														<img id="auditIcon" src=" <?php echo site_url('uploads/audit-icon.png'); ?>" />
													</a>
													<p style="text-align: center; font-weight: bold; font-style: italic;">Click to See</p>
												</td>
												<td style="font-size: 16px;">
													<p>We have performed a custom site inspection/audit of this site including maps, images and more</p>
													<p><a href="<?php echo $proposal->getAuditReportUrl(true) ?>" target="_blank">View your Custom Site Inspection/Audit Report</a></p>
												</td>
											</tr>
										</table>
										<div class="audit-footer"></div>
									</div>
								</div>
								<?php    }

							$k = 0;
							foreach ($services as $service) {

								$k++;

								if (!$proposal->hasSnow()) {
								?>
									<div class="col-md-12 margin-top-bottom-10" id="service_<?php echo $service->getServiceId() ?>">
										<div class="item-content<?php echo ($service->isNoPrice()) ? ' no-price' : ''; ?>">
											<h2><?php echo $service->getServiceName() ?></h2>
											<div class="item-content-texts">
												<?php echo $services_texts[$service->getServiceId()]; ?>
											</div>
											<?php if (!$lumpSum  && !$service->isNoPrice()) {
												$price = (float) str_replace($s, $r, $service->getPrice());
												$taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
											?>

												<span style="padding-left: 40px; margin-top: 0;">Total Price: <?php echo   '$' . number_format(($price - $taxprice), 2);   ?></span>

											<?php } ?>
										</div>
									</div>
								<?php
								} else {
								?>
									<div class="col-md-12 margin-top-bottom-10" id="service_<?php echo $service->getServiceId() ?>" style="page-break-inside: avoid">
										<div class=" item-content">
											<h2><?php echo $service->getServiceName() ?></h2>
											<?php echo $services_texts[$service->getServiceId()]; ?>
											<?php if ($service->getPricingType() != 'Noprice') {
												switch ($service->getPricingType()) {
													case 'Trip':
											?>
														<p style="padding-left: 40px;">Price Per Trip: <?php echo $service->getFormattedPrice()  ?></p>
													<?php
														break;
													case 'Season':
													?>
														<p style="padding-left: 40px;">Total Seasonal Price for this item: <?php echo $service->getFormattedPrice()  ?></p>
													<?php
														break;
													case 'Year':
													?>
														<p style="padding-left: 40px;">Total Yearly Price for this item: <?php echo $service->getFormattedPrice()  ?></p>
													<?php
														break;
													case 'Month':
													?>
														<p style="padding-left: 40px;">Total Monthly Price for this item: <?php echo $service->getFormattedPrice()  ?></p>
													<?php
														break;
													case 'Hour':
													?>
														<p style="padding-left: 40px;">This item has a <?php echo $service->getFormattedPrice()  ?> hourly price</p>
													<?php
														break;
													case 'Materials':
													?>
														<p style="padding-left: 40px;">This item is priced <?php echo $service->getFormattedPrice()  ?> Per <?php echo $service->getMaterial() ?></p>
													<?php
														break;
													default:
														//total and new one
													?>
														<p style="padding-left: 40px;">Total Price for this item: <?php echo $service->getFormattedPrice()  ?></p>
											<?php
														break;
												}
											} ?>
										</div>
									</div>
							<?php
								}
							} ?>
						</div>
					</div>
				</div>

				<!-- END INVOICE -->

				<?php 
				$images2 = array();
				if (count($images)) { ?>
				<!-- BEGIN INVOICE -->

				<div class="grid invoice" style="padding-top: 10px;">
					<div class="grid-body">


						<div class="row" id="images">
						
								<div class="row" id="gallery" data-toggle="modal" data-target="#exampleModal">
									<?php
									
									foreach ($images as $k => $image) {
										if ($images[$k]['image']->getActive()) {
											$img = array();
											$img['src'] = $images[$k]['websrc'];
											$img['path'] = $images[$k]['path'];
											if (file_exists($img['path'])) {
												$img['orientation'] = $images[$k]['orientation'];
												$img['title'] = $images[$k]['image']->getTitle();
												$img['notes'] = $images[$k]['image']->getNotes();
												$img['image_layout'] = $images[$k]['image']->getImageLayout();
												$images2[] = $img;
											}
										}
									}
									//new world order code
									$imageCount = 0; //image counter
									$tableOpen = 0; //variable to check if the table open
									$old_layout = 0;
									$j = 0;
									foreach ($images2 as $image) {






									?>
										<div class="col-12 col-sm-6 col-md-6 mg-btm-20">
											<h2 style="text-align: center;"><?php echo $image['title'] ?></h2>
											<img data-slide="slide-image-<?= $j; ?>" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight2" aria-controls="offcanvasRight" class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?> img-fluid img-thumbnail btn showProposalCarousel" style="object-fit: cover; height:280px; width:100%;" src="<?php echo $image['src']; ?>" alt="">
											<h2 style="text-align: center;margin-top: 10px;">Notes:</h2>
											<div style="text-align: left;"><?php echo $image['notes']; ?></div><br>
										</div>
										<!-- <div class="col-12 col-sm-6 col-md-6 mg-btm-20">
											<img class="w-100" src="<?php // echo $image['src']; 
																	?>" data-target="#carouselExample" data-slide-to="<?= $j; ?>">
										</div> -->

								<?php
										$j++;
									}
									?>
								</div>
								
								
						</div>
					</div>
				</div>
				<?php } ?>


				<!-- END INVOICE -->

				<!-- BEGIN INVOICE -->
				<?php
				if ($proposal->getVideoURL() <> '') {
					$buttonShow = false;
					
					$url = $proposal->getVideoURL();
					$finalUrl = '';
					if(strpos($url, 'facebook.com/') !== false) {
						//it is FB video
						$finalUrl.='https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=1&width=200';
					}else if(strpos($url, 'vimeo.com/') !== false) {
						//it is Vimeo video
						$videoId = explode("vimeo.com/",$url)[1];
						if(strpos($videoId, '&') !== false){
							$videoId = explode("&",$videoId)[0];
						}
						$finalUrl.='https://player.vimeo.com/video/'.$videoId;
					}else if(strpos($url, 'youtube.com/') !== false) {
						if (strpos($proposal->getVideoURL(), 'embed') > 0) {
							$finalUrl = $proposal->getVideoURL();
						} else {
							//it is Youtube video
							$videoId = explode("v=",$url)[1];
							if(strpos($videoId, '&') !== false){
								$videoId = explode("&",$videoId)[0];
							}
							$finalUrl.='https://www.youtube.com/embed/'.$videoId;
						}
					}else if(strpos($url, 'youtu.be/') !== false){
						//it is Youtube video
						$videoId = explode("youtu.be/",$url)[1];
						if(strpos($videoId, '&') !== false){
							$videoId = explode("&",$videoId)[0];
						}
						$finalUrl.='https://www.youtube.com/embed/'.$videoId;
					}else if(strpos($url, 'screencast.com/') !== false){
						$finalUrl = $proposal->getVideoURL();
					}else if(strpos($proposal->getVideoURL(), 'dropbox.com') !== false) {
						$finalUrl = str_replace('dl=0','raw=1',$proposal->getVideoURL());

					} else {
						$buttonShow = true;
						$finalUrl = $proposal->getVideoURL();
					}
				?>
					<div class="grid invoice" style="padding-top: 10px;">
						<div class="grid-body">

							<div class="row" id="video">
							<div class="col-md-12">
								<h1 class="title_big2" style="z-index: 200;text-align:center;padding-bottom: 20px;">Proposal Video</h1>
							</div>	
							<?php if($buttonShow) { ?>
								<a href="<?php echo $url; ?>" class="btn btn-primary" style="width:150px;" target="_blank">Proposal Video</a>
							<?php } else {?>
								<div class="embed-responsive embed-responsive-16by9">
									<iframe  class="embed-responsive-item" src="<?php echo $finalUrl; ?>" allowfullscreen></iframe>
								</div>
							<?php } ?>
							</div>
						</div>
					</div>
				<?php } ?>
				<!-- END INVOICE -->
				<!-- BEGIN INVOICE -->

				<div class="grid invoice" style="padding-top: 10px;">
					<div class="grid-body">
						<div class="row">
							<h1 class="underlined global_header">Price Breakdown: <?php echo $proposal->getProjectName() ?></h1>
							<div class="logotopright"><img class="theLogo" style="height: 40px; width: 120px; margin-right: 8px;" src="<?php echo site_url('uploads/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo()) ?>" alt=""></div>
						</div>
						<div class="row" id="price-breakdown">
							<p>Please find the following breakdown of all services we have provided in this proposal.</p>
							<p>This proposal originated on <?php echo date('F d, Y', $proposal->getCreated(false)) ?>.
								<?php
								if ($proposal->getJobNumber()) {
								?>
									<strong>Job Number:</strong> <?php echo $proposal->getJobNumber() ?>
								<?php
								}
								?>
							</p>

							<?php

							// Separate optional services, and no price services
							$optionalServices = [];
							$taxServices = [];
							$isMapDataAdded = false;
							$isMapDataAddedOS = false;
							foreach ($services as $k => $serviceItem) {
								if ($serviceItem->isOptional()) {
									unset($services[$k]);
									$optionalServices[] = $serviceItem;
									if ($serviceItem->getMapAreaData() != '') {
										$isMapDataAddedOS = true;
									}
								} else {
									if ($serviceItem->getMapAreaData() != '') {
										$isMapDataAdded = true;
									}
								}
								if ($serviceItem->isNoPrice()) {
									unset($services[$k]);
								}
								if ($serviceItem->getTax()) {
									unset($services[$k]);
									$taxServices[] = $serviceItem;
								}
							}


							// Use standard layout for non-snow
							if (!$proposal->hasSnow()) {


							?>
								<div class="table-container">
									<table width="100%" class="table table-striped table-sm" border="0">
										<thead>
											<tr>
												<td width="10%"><strong>Item</strong></td>
												<td width="45%"><strong>Description</strong></td>
												<?php if ($isMapDataAdded) { ?><td width="25%"><strong>Map Area</strong></td> <?php } ?>
												<td width="20%" style="text-align: right"><strong>Cost</strong></td>
											</tr>
										</thead>
										<tbody>
											<?php
											$k = 0;
											$total = 0;
											$taxTotal = 0;
											$taxSubTotal = 0;
											$isTaxApplied = false;

											foreach ($services as $service) {
												$k++;
												$taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
											?>
												<tr>
													<td <?php if ($k % 2) {
															echo 'class="odd"';
														} ?>><?php echo $k; ?></td>
													<td <?php if ($k % 2) {
															echo 'class="odd"';
														} ?>> <?php
																if ($taxprice > 0) {
																	echo '<span style="font-weight:bold;vertical-align: sub;">* </span>';
																	$isTaxApplied = true;
																}
																//fix for the price breakdown to show service name instead of Additional Service
																echo $service->getServiceName();
																?></td>

													<?php if ($isMapDataAdded) { ?><td <?php if ($k % 2) {
																							echo 'class="odd"';
																						} ?>> <?php echo $service->getMapAreaData(); ?></td><?php } ?>

													<td <?php echo ($k % 2) ? ' class="odd"' : ''; ?> style="text-align: right">
														<?php
														// Price required for calculations
														$price = (float) str_replace($s, $r, $service->getPrice());


														if ($lumpSum) {
															echo 'Included';
														} else {
															//echo $service->getFormattedPrice();
															echo '$' . number_format(($price - $taxprice), 2);
														}
														?>
													</td>
												</tr>
											<?php
												$total += $price;
												$taxSubTotal += $taxprice;
											}
											?>
										</tbody>
										<?php if (!isset($hideTotalPrice) || !$hideTotalPrice) { ?>
											<tfoot>
												<?php if (count($taxServices)) { ?>
													<tr>
														<td></td>
														<?php if ($isMapDataAdded) { ?><td></td> <?php } ?>
														<td align="right">Subtotal:</td>
														<td style="text-align: right">$<?php echo number_format($total, 2) ?></td>
													</tr>
													<?php
													foreach ($taxServices as $taxService) {
														$taxTotal += $taxService->getPrice(true);
													}
													?>
													<tr>
														<td></td>
														<?php if ($isMapDataAdded) { ?><td></td> <?php } ?>
														<td align="right">Tax:</td>
														<td style="text-align: right">$<?php echo number_format($taxTotal, 2) ?></td>
													</tr>
												<?php } ?>
												<?php if ($taxSubTotal > 0) { ?>
													<tr>
														<td></td>
														<?php if ($isMapDataAdded) { ?><td></td> <?php } ?>
														<td align="right"><strong>Tax:</strong></td>
														<td style="text-align: right">$<?php echo number_format($taxSubTotal, 2) ?></td>
													</tr>
												<?php } ?>
												<tr>
													<td></td>
													<?php if ($isMapDataAdded) { ?><td></td> <?php } ?>
													<td align="right"><strong>Total:</strong></td>
													<td style="text-align: right"><strong>$<?php echo number_format($total + $taxTotal, 2) ?></strong></td>
												</tr>
											</tfoot>
										<?php
										} ?>
									</table>
								</div>
								<?php
								if (count($optionalServices)) {
								?>
									<h2>Optional Services:</h2>
									<div class="table-container">
										<table width="100%" class="table table-striped table-sm" border="0">
											<thead>
												<tr>
													<td width="10%"><strong>Item</strong></td>
													<td width="45%"><strong>Description</strong></td>
													<?php if ($isMapDataAddedOS) { ?><td width="25%"><strong>Map Area</strong></td> <?php } ?>
													<td width="20%" style="text-align: right"><strong>Cost</strong></td>
												</tr>
											</thead>
											<tbody>
												<?php
												$k = 0;
												$total = 0;
												$taxSubTotal = 0;
												$isTaxApplied = false;
												foreach ($optionalServices as $service) {
													$k++;
													$taxPrice = 0;
													if ($service->getTaxPrice()) {
														$taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
													}
												?>
													<tr>
														<td <?php if ($k % 2) {
																echo 'class="odd"';
															} ?>><?php echo $k; ?></td>
														<td <?php if ($k % 2) {
																echo 'class="odd"';
															} ?>>
															<?php
															if (floatval($taxprice > 0)) {
																echo '<span style="font-weight:bold;vertical-align: sub;">* </span>';
																$isTaxApplied = true;
															}
															//fix for the price breakdown to show service name instead of Additional Service
															echo $service->getServiceName();
															?></td>
														<?php if ($isMapDataAddedOS) { ?><td <?php if ($k % 2) {
																									echo 'class="odd"';
																								} ?>> <?php echo $service->getMapAreaData(); ?></td><?php } ?>
														<td <?php echo ($k % 2) ? ' class="odd"' : ''; ?> style="text-align: right">
															<?php
															// Price required for calculations
															$price = (float) str_replace($s, $r, $service->getPrice());

															//echo $service->getFormattedPrice();
															echo '$' . number_format(($price - $taxprice), 2);
															?>
														</td>
													</tr>
												<?php
													$total += $price;
													$taxSubTotal += $taxprice;
												}
												?>
											</tbody>
											<?php if (!isset($hideTotalPrice) || !$hideTotalPrice) { ?>
												<tfoot>
													<?php if ($taxSubTotal > 0) { ?>
														<tr>
															<td></td>
															<?php if ($isMapDataAddedOS) { ?><td></td> <?php } ?>
															<td align="right"><strong>Tax:</strong></td>
															<td style="text-align: right">$<?php echo number_format($taxSubTotal, 2) ?></td>
														</tr>
													<?php } ?>
													<!--
                    <tr>
                        <td></td>
                        <td align="right"><strong>Total:</strong></td>
                        <td style="text-align: right"><strong>$<?php echo number_format($total + $taxSubTotal, 2) ?></strong></td>
                    </tr>
                    -->
												</tfoot>
											<?php } ?>
										</table>
									</div>
								<?php
								}
							} else {
								// Snow proposal
								?>
								<div class="table-container">
									<h4 style="margin-top: 0; padding-top: 0; margin-bottom: 0; padding-bottom: 0; font-size:15px">Service Pricing</h4>
									<table width="100%" class="table" border="0" style="margin-bottom: 0;">
										<thead>
											<tr>
												<td width="20"><strong>Item</strong></td>
												<td width="200"><strong>Description</strong></td>
												<td><strong>Freq.</strong></td>
												<td><strong>Type</strong></td>
												<td align="right"><strong>Price</strong></td>
												<td align="right"><strong>Total</strong></td>
											</tr>
										</thead>
										<tbody>
											<?php
											$k = 0;
											$total = 0;
											$hiddenPrices = array('Noprice', 'Hour', 'Materials');
											$timeMaterialServices = array('Hour', 'Materials');
											$fixedPrices = array('Total', 'Year');
											$timeMaterial = false;
											foreach ($services as $service) {
												if (in_array($service->getPricingType(), $timeMaterialServices)) {
													$timeMaterial = true;
												}
												if (!in_array($service->getPricingType(), $hiddenPrices) && !in_array($service->getPricingType(), $timeMaterialServices)) {
													$k++;
													$class = ($k % 2) ? 'odd' : '';
											?>
													<tr>
														<td class="<?php echo $class; ?>"><?php echo $k; ?></td>
														<td class="<?php echo $class; ?>"><?php
																							//fix for the price breakdown to show service name instead of Additional Service
																							echo $service->getServiceName();
																							?></td>
														<td class="<?php echo $class; ?>"><?php
																							if (!in_array($service->getPricingType(), $hiddenPrices) && !in_array($service->getPricingType(), $fixedPrices)) {
																								$amountQty = (is_numeric($service->getAmountQty())) ? $service->getAmountQty() : 0;
																								echo $amountQty;
																							}
																							?></td>
														<td class="<?php echo $class; ?>"><?php
																							switch ($service->getPricingType()) {
																								case 'Total':
																									echo 'Fixed Price';
																									break;
																								default:
																									echo 'Per ' . $service->getPricingType();
																									break;
																							}
																							?></td>
														<td align="right" class="<?php echo $class; ?>">$<?php
																											$price = (float) str_replace($s, $r, $service->getPrice());
																											echo @number_format($price, 2);
																											?></td>
														<td class="<?php echo $class; ?>" align="right"><?php
																										if (!in_array($service->getPricingType(), $hiddenPrices)) {
																											if (in_array($service->getPricingType(), $fixedPrices)) {
																												$amountQty = 1;
																											}
																											$partialTotal = ((float) str_replace($s, $r, $price) * $amountQty);
																											echo '$' . number_format($partialTotal, 2);
																										}
																										?></td>
													</tr>
											<?php
													if (!in_array($service->getPricingType(), $hiddenPrices)) {
														$total += $partialTotal;
													}
												}
											}
											?>
										</tbody>
										<?php if (!isset($hideTotalPrice) || !$hideTotalPrice) { ?>
											<tfoot>
												<tr>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td align="right"><b>Total</b></td>
													<td align="right"><b>$<?php echo number_format($total, 2) ?></b></td>
												</tr>
											</tfoot>
										<?php } ?>
									</table>
									<?php if ($timeMaterial) { ?>
										<h4 style="margin-top: 0; padding-top: 0; margin-bottom: 0; padding-bottom: 0; font-size: 15px">Time & Material Items</h4>
										<table width="100%" class="table" border="0">
											<thead>
												<tr>
													<td width="20"><strong>Item</strong></td>
													<td width="350"><strong>Description</strong></td>
													<td align="right"><strong>Price</strong></td>
													<td align="right"><strong>Type</strong></td>
												</tr>
											</thead>
											<tbody>
												<?php
												$k = 0;
												foreach ($services as $service) {
													if (in_array($service->getPricingType(), $timeMaterialServices)) {
														$k++;
														$class = ($k % 2) ? 'odd' : '';
												?>
														<tr>
															<td class="<?php echo $class; ?>"><?php echo $k; ?></td>
															<td class="<?php echo $class; ?>"><?php echo $service->getServiceName(); ?></td>
															<td align="right" class="<?php echo $class; ?>">$<?php
																												$price = (float) str_replace($s, $r, $service->getPrice());
																												echo @number_format($price, 2);
																												?></td>
															<td align="right" class="<?php echo $class; ?>">Per <?php echo ($service->getPricingType() != 'Materials') ? $service->getPricingType() : $service->getMaterial(); ?></td>
														</tr>
												<?php
													}
												}
												?>
											</tbody>
										</table>
									<?php } ?>
								</div>
							<?php
							}
							if (trim($proposal->getClient()->getCompany()->getContractCopy())) { ?>
								<h2 style="margin-top: 2px; margin-top: 20px;">Authorization to Proceed & Contract</h2>
								<p style="padding: 0; margin: 0;"><?php echo ($proposal->getContractCopy()) ? $proposal->getContractCopy() : $proposal->getClient()->getCompany()->getContractCopy() ?></p>
							<?php }
							?>
						</div>
					</div>
				</div>

				<!-- END INVOICE -->
				<!-- BEGIN INVOICE -->

				<div class="grid invoice" style="padding-top: 10px;">
					<div class="grid-body">

						<div class="row">



							<div style="page-break-inside: avoid" id="signature">

								<h2 style="margin-top: 10px;">Payment Terms</h2>

								<p style="padding: 0; margin: 0;"><?php echo ($proposal->getPaymentTerm() == 0) ? 'We agree to pay the total sum or balance in full upon completion of this project.' : 'We agree to pay the total sum or balance in full ' . $proposal->getPaymentTerm() . ' days after the completion of work.'; ?></p>

								<!--Dynamic Section-->
								<?php
								echo ($proposal->getPaymentTermText()) ? $proposal->getPaymentTermText() : $proposal->getOwner()->getCompany()->getPaymentTermText();
								?>
								<!--The signature and stuff-->

								<table border="0">
									<tr>
										<td width="30">Date:</td>
										<td width="182" style="border-bottom: 1px solid #000;">&nbsp;</td>
									</tr>
								</table>


								<?php
								if (!file_exists(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg') || $companySig) {
									echo '<br /><br />';
								}
								?>

								<table border="0">
									<tr>
										<td width="230" class="client_signature_td" style="border-bottom: 1px solid #000; padding: 0 0 2px 0;">
											<?php if (file_exists(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/client_signature.png')) { ?>
												<img style="width: auto; max-height: 70px;" src="<?php echo site_url('uploads/proposal_signature/' . $proposal->getProposalId() . '/client_signature.png'); ?>" alt="">
											<?php } else {

											?>
												<button type="button" id="add_signature" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" class="btn btn-primary btn-sm">Add Signature</button>
										</td>

									<?php
											}
									?>
									<td width="65" style="padding: 0;">&nbsp;</td>
									<td width="230" style="border-bottom: 1px solid #000; padding: 0 0 2px 0;"><?php
																												if (file_exists(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg') && !$companySig) {
																												?>
											<img style="width: auto; height: 70px;" src="<?php echo site_url('uploads/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg'); ?>" alt="">
										<?php
																												}
										?>
									</td>
									</tr>
									<tr>
										<td valign="top" width="220" style="line-height: 1.3">
											<?php
											if ($clientSig) {
											?>

												<?php echo $clientSig->getName() . ' | ' . $clientSig->getTitle(); ?><br />
												<?php echo $clientSig->getCompanyName() ?><br />
												<?php echo $clientSig->getAddress() ?><br />
												<?php echo $clientSig->getCity() ?> <?php echo $clientSig->getState(); ?> <?php echo $clientSig->getZip() ?><br />
												<?php
												if ($clientSig->getEmail()) {
												?>
													<a href="mailto:<?php echo $clientSig->getEmail(); ?>"><?php echo $clientSig->getEmail(); ?></a><br />
												<?php
												}
												?>
												<?php
												if ($clientSig->getCellPhone()) {
												?>
													C: <?php echo $clientSig->getCellPhone(); ?><br />
												<?php
												}
												?>
												<?php
												if ($clientSig->getOfficePhone()) {
												?>
													O: <?php echo $clientSig->getOfficePhone(); ?><br />
												<?php
												}

												?>
											<?php
											} else {
												echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName();
												if ($proposal->getClient()->getTitle()) {
													echo ' | ' . $proposal->getClient()->getTitle();
												}
											?> <br>
												<?php echo $proposal->getClient()->getClientAccount()->getName() ?><br>
												<?php echo $proposal->getClient()->getAddress() ?><br>
												<?php echo $proposal->getClient()->getCity() . ', ' . $proposal->getClient()->getState() . ' ' . $proposal->getClient()->getZip() ?>
												<br>
												<a href="mailto:<?php echo $proposal->getClient()->getEmail() ?>">
													<?php echo $proposal->getClient()->getEmail() ?></a><br>
												<?php
												$ph = 0;
												if ($proposal->getClient()->getCellPhone()) {
													echo 'C: ' . $proposal->getClient()->getCellPhone();
													$ph = 1;
												}
												if ($proposal->getClient()->getBusinessPhone()) {
													if ($ph) {
														echo '<br>';
													}
													echo 'O: ' . $proposal->getClient()->getBusinessPhone(true);
												}
											}
											if ($clientSignature) {
												echo '<br>';
												?>
												<span id="signed_span">Signed : <?= date_format(date_create($clientSignature->getCreatedAt()), "m/d/y g:i A"); ?></span>
											<?php
											}else{echo '<br><span id="signed_span"></span>';}
											?><br>
										</td>
										<td width="65"></td>
										<td valign="top" width="220" style="line-height: 1.3">

											<?php
											if ($companySig) {
											?>
												<?php echo $companySig->getName() . ' | ' . $companySig->getTitle(); ?><br />
												<?php echo $companySig->getCompanyName() ?><br />
												<?php echo $companySig->getAddress() ?><br />
												<?php echo $companySig->getCity() ?> <?php echo $companySig->getState(); ?> <?php echo $companySig->getZip() ?><br />
												<?php
												if ($companySig->getEmail()) {
												?>
													<a href="mailto:<?php echo $companySig->getEmail(); ?>"><?php echo $companySig->getEmail(); ?></a><br />
												<?php
												}
												?>
												<?php
												if ($companySig->getCellPhone()) {
												?>
													C: <?php echo $companySig->getCellPhone(); ?><br />
												<?php
												}
												?>
												<?php
												if ($companySig->getOfficePhone()) {
												?>
													O: <?php echo $companySig->getOfficePhone(); ?><br />
												<?php
												}
												?>
											<?php } else { ?>
												<?php echo $proposal->getOwner()->getFirstName() . ' ' . $proposal->getOwner()->getLastName() . ' | ' . $proposal->getOwner()->getTitle(); ?>
												<br>
												<?php echo $proposal->getOwner()->getCompany()->getCompanyName(); ?>
												<br>
												<?php echo $proposal->getOwner()->getAddress() ?><br>
												<?php echo $proposal->getOwner()->getCity() ?>, <?php echo $proposal->getOwner()->getState() ?> <?php echo $proposal->getOwner()->getZip() ?><br>
												E: <a href="mailto:<?php echo $proposal->getOwner()->getEmail() ?>"><?php echo $proposal->getOwner()->getEmail() ?></a><br>
												C: <?php echo $proposal->getOwner()->getCellPhone() ?><br />
												P: <?php echo $proposal->getOwner()->getOfficePhoneExt() ? $proposal->getOwner()->getOfficePhone() . ' Ext ' . $proposal->getOwner()->getOfficePhoneExt() : $proposal->getOwner()->getOfficePhone(); ?><br>
												<?php if ($proposal->getClient()->getCompany()->getFax() || $proposal->getOwner()->getFax()) { ?>
													F: <?php echo ($proposal->getOwner()->getFax()) ? $proposal->getOwner()->getFax() : $proposal->getClient()->getCompany()->getFax() ?><br>
												<?php } ?>
												<a href="<?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?>"><?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?></a>
											<?php } ?>
										</td>
									</tr>
								</table>
							</div>
						</div>

					</div>
				</div>
				<!-- END INVOICE -->
				<?php

				if (count($specs)) { ?>
					<!-- BEGIN INVOICE -->

					<div class="grid invoice" style="padding-top: 10px;">
						<div class="grid-body">
							<div class="row">


								<div style="page-break-after: always"></div>
								<!--Hide Header code start-->
								<div class="header-hider"></div>
								<!--Hide Header code end-->
								<h1 class="underlined header_fix" style="z-index: 200;">Product Info</h1>
								<?php
								foreach ($specs as $item => $specz) {
								?>
									<div class="spec">
										<h2><?php echo $item ?></h2>

										<div class="spec-content">
											<?php
											foreach ($specz as $spec) {
												echo $spec;
											}
											?>
										</div>
									</div>
								<?php
								} ?>
							</div>

						</div>
					</div>
				<?php } ?>

				<!-- END INVOICE -->





				<?php
				if ($havetexts) { ?>
					<!-- BEGIN INVOICE -->

					<div class="grid invoice" style="padding-top: 10px;">
						<div class="grid-body">
							<div class="row">
								<h1 class="underlined global_header">Additional Info: <?php echo $proposal->getProjectName() ?></h1>
								<div class="logotopright"><img class="theLogo" style="height: 40px; width: 120px; margin-right: 8px;" src="<?php echo site_url('uploads/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo()); ?>" alt=""></div>
							</div>
							<div class="row">
								<?php
								foreach ($proposal_categories as $catId => $on) {
									if ($on && isset($categories[$catId])) {
										$cat = $categories[$catId];
										if (count($cat['texts'])) {
								?>
											<h2 id="custom_text_<?= $catId; ?>"><?php echo $cat['name'] ?></h2>
											<ol>
												<?php
												foreach ($cat['texts'] as $text) {
												?>
													<li><?php echo $text; ?></li><?php
																				}
																					?>
											</ol>
								<?php
										}
									}
								} ?>
							</div>

						</div>
					</div>
				<?php } ?>
				<!-- END INVOICE -->
				<?php
				if ($proposal->getInventoryReportUrl()) { ?>
					<!-- BEGIN INVOICE -->

					<div class="grid invoice" style="padding-top: 10px;">
						<div class="grid-body">
							<div class="row">
								<div class="item-content audit">
									<h2>Property Inventory Details</h2>

									<table>
										<tr>
											<td style="text-align: center">
												<a href="https://local.psa/location/inventory/report/<?php echo $proposal->getInventoryReportUrl() ?>" target="_blank" style="display: block">
													<img id="auditIcon" src="<?php echo site_url('uploads/audit-icon.png'); ?>" />
												</a>
												<p style="text-align: center; font-weight: bold; font-style: italic;">Click to See</p>
											</td>
											<td style="font-size: 16px;">
												<p>We have performed an inventory of your site</p>
												<p><a href="https://local.psa/location/inventory/report/<?php echo $proposal->getInventoryReportUrl() ?>" target="_blank">View your
														Custom Site Inventory Report</a></p>
											</td>
										</tr>
									</table>
									<div class="audit-footer"></div>
								</div>
							</div>

						</div>
					</div>
					<!-- END INVOICE -->
					<?php
					// Do we have inventory Data
					if ($inventoryData) {
						if (count($inventoryData->data->breakdown)) { ?>
							<!-- BEGIN INVOICE -->

							<div class="grid invoice" style="padding-top: 10px;">
								<div class="grid-body">
									<div class="row">
										<div style="padding-top: 30px; page-break-inside: avoid;">
											<h3>Inventory Breakdown</h3>

											<table class="table inventoryTable" style="width: 100%;" border="none" cellspacing="0">
												<thead>
													<tr>
														<th>Category</th>
														<th>Type</th>
														<th>Name</th>
														<th>Area (ft<sup>2</sup>)</th>
														<th>Area (yds<sup>2</sup>)</th>
														<th>Length (ft)</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$kk = 1;
													foreach ($inventoryData->data->breakdown as $breakdownData) {
														$class = ($kk % 2) ? 'odd' : '';
													?>
														<tr class="<?php echo $class; ?>">
															<td><?php echo $breakdownData->categoryName; ?></td>
															<td><?php echo $breakdownData->typeName; ?></td>
															<td><?php echo $breakdownData->assetName; ?></td>
															<td><?php echo $breakdownData->area_m ? number_format($breakdownData->area_m * M_TO_SQ_FT) : '-'; ?></td>
															<td><?php echo $breakdownData->area_m ? number_format(($breakdownData->area_m * M_TO_SQ_FT) / 9) : '-'; ?></td>
															<td><?php echo $breakdownData->length_m ? number_format($breakdownData->length_m * M_TO_FT) : '-'; ?></td>
														</tr>
													<?php
														$kk++;
													}
													?>
												</tbody>
											</table>
										</div>

									</div>

								</div>
							</div>
						<?php
						} ?>
						<!-- END INVOICE -->
						<?php if (count($inventoryData->data->totals)) { ?>
							<!-- BEGIN INVOICE -->

							<div class="grid invoice" style="padding-top: 10px;">
								<div class="grid-body">
									<div class="row">
										<div style="padding-top: 30px; page-break-inside: avoid;">
											<h3>Inventory Totals</h3>

											<table class="table inventoryTable" style="width: 100%;" border="none" cellspacing="0">
												<thead>
													<tr>
														<th>Category</th>
														<th>Type</th>
														<th># Items</th>
														<th>Total Area (ft<sup>2</sup>)</th>
														<th>Total Area (yds<sup>2</sup>)</th>
														<th>Total Length (ft)</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$kk = 1;
													foreach ($inventoryData->data->totals as $totalsData) {
														$class = ($kk % 2) ? 'odd' : '';
													?>
														<tr class="<?php echo $class; ?>">
															<td><?php echo $totalsData->categoryName; ?></td>
															<td><?php echo $totalsData->typeName; ?></td>
															<td><?php echo $totalsData->typeCount; ?></td>
															<td><?php echo $totalsData->typeArea ? number_format($totalsData->typeArea * M_TO_SQ_FT) : '-'; ?></td>
															<td><?php echo $totalsData->typeArea ? number_format(($totalsData->typeArea * M_TO_SQ_FT) / 9) : '-'; ?></td>
															<td><?php echo $totalsData->typeLength ? number_format($totalsData->typeLength * M_TO_FT) : '-'; ?></td>
														</tr>
													<?php
														$kk++;
													}
													?>
												</tbody>
											</table>
										</div>
									</div>

								</div>
							</div>
						<?php
						} ?>
						<!-- END INVOICE -->
						<?php if (count($inventoryData->data->zoneItems)) { ?>
							<!-- BEGIN INVOICE -->

							<div class="grid invoice" style="padding-top: 10px;">
								<div class="grid-body">
									<div class="row">
										<div style="padding-top: 30px; page-break-inside: avoid;">
											<h3>Inventory Zone Items Breakdown</h3>

											<table class="table inventoryTable" style="width: 100%;" border="none" cellspacing="0">
												<thead>
													<tr>
														<th>Category</th>
														<th>Type</th>
														<th>Zone Name</th>
														<th>Zone Item</th>
														<th>Value</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$kk = 1;
													foreach ($inventoryData->data->zoneItems as $zoneItemsData) {
														$class = ($kk % 2) ? 'odd' : '';
													?>
														<tr class="<?php echo $class; ?>">
															<td><?php echo $zoneItemsData->categoryName; ?></td>
															<td><?php echo $zoneItemsData->typeName; ?></td>
															<td><?php echo $zoneItemsData->assetName; ?></td>
															<td><?php echo $zoneItemsData->attributeTypeName ?></td>
															<td><?php echo $zoneItemsData->attributeValue ?></td>
														</tr>
													<?php
														$kk++;
													}
													?>
												</tbody>
											</table>
										</div>
									</div>

								</div>
							</div>
						<?php
						} ?>
						<!-- END INVOICE -->
						<?php if (count($inventoryData->data->zoneItemTotals)) {
						?>
							<!-- BEGIN INVOICE -->

							<div class="grid invoice" style="padding-top: 10px;">
								<div class="grid-body">
									<div class="row">
										<div style="padding-top: 30px; page-break-inside: avoid;">
											<h3>Inventory Zone Item Totals</h3>

											<table class="table inventoryTable" style="width: 100%;" border="none" cellspacing="0">
												<thead>
													<tr>
														<th>Category</th>
														<th>Zone Item</th>
														<th>Total</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$kk = 1;
													foreach ($inventoryData->data->zoneItemTotals as $zoneItemTotalData) {
														$class = ($kk % 2) ? 'odd' : '';
													?>
														<tr class="<?php echo $class; ?>">
															<td><?php echo $zoneItemTotalData->categoryName; ?></td>
															<td><?php echo $zoneItemTotalData->typeName; ?></td>
															<td><?php echo $zoneItemTotalData->typeCount; ?></td>
														</tr>
													<?php
														$kk++;
													}
													?>
												</tbody>
											</table>
										</div>
									</div>

								</div>
							</div>
				<?php
						}
					}
				}
				?>
				<!-- END INVOICE -->

			</div>

			




			<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
				<div class="offcanvas-header">
					<legend class="text-left">Add Signature : <?php echo $proposal->getProposalTitle() ?></legend>
					<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
				<form id="clientSignatureForm" onsubmit="return false;"  class="g-3 needs-validation" novalidate>
					<div class="row">

						<hr />
						<div class="alert alert-primary" role="alert">
							<i class="fa fa-fw fa-info-circle"></i> Draw or upload your signature below to accept the contract. We will email you a copy of the proposal to confirm.
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-6 mb-3">
									<label for="signature_firstname" class="form-label">First Name</label>
									<?php 
										if($clientSig){
											$client_names = explode(" ",$clientSig->getName());
											$client_firstname = @$client_names[0];
											$client_lastname = @$client_names[1];
										}

									?>
									<input type="text" required name="firstname" class="form-control" value="<?php echo ($clientSig) ? $client_firstname : $proposal->getClient()->getFirstName(); ?>" id="signature_firstname" placeholder="Enter First Name">
									<div class="invalid-feedback"> Please enter First Name</div>
								</div>
								<div class="col-md-6 mb-3">
									<label for="signature_lastname" class="form-label">Last Name</label>
									<input type="text" required name="lastname" class="form-control" value="<?php echo ($clientSig) ? $client_lastname : $proposal->getClient()->getLastName(); ?>" id="signature_lastname" placeholder="Enter Last Name">
									<div class="invalid-feedback"> Please enter Last Name</div>

								</div>
							</div>
							<div class="row">
								<div class="col-md-6 mb-3">
									<label for="signature_company" class="form-label">Company Name</label>
									<input type="text" required name="company" class="form-control" value="<?php echo ($clientSig) ? $clientSig->getCompanyName() : $proposal->getClient()->getClientAccount()->getName(); ?>"  id="signature_company" placeholder="Enter Company Name">
									<div class="invalid-feedback"> Please enter Company Name</div>

								</div>
								<div class="col-md-6 mb-3">
									<label for="signature_title" class="form-label">Title</label>
									<input type="text" required name="signature_title" class="form-control" value="<?php echo ($clientSig) ? $clientSig->getTitle() : $proposal->getClient()->getTitle(); ?>" id="signature_title" placeholder="Enter Title">
									<div class="invalid-feedback"> Please enter Title</div>
									<input type="hidden" id="proposal_id" name="proposal_id" value="<?= $proposal->getProposalId(); ?>">
									<input type="hidden" id="signature_url" name="signature_url" value="">
								</div>
								
							</div>
							<div class="mb-3">
									<label for="signature_email" class="form-label">Email</label>
									<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required name="email" class="form-control" value="<?php echo ($clientSig) ? $clientSig->getEmail() : $proposal->getClient()->getEmail(); ?>"  id="signature_email" placeholder="Enter Email">
									<div class="invalid-feedback"> Please enter a valid Email</div>

								</div>
							
							<div class="mb-3">
								<label for="signature_comments" class="form-label">Comments</label>
								<textarea class="form-control" id="signature_comments" rows="3" placeholder="Enter Comments"></textarea>
							</div>



						</div>
						<div class="col-md-6">
							<label class="form-label">Signature</label>
							<nav>
								<div class="nav nav-tabs" id="nav-tab" role="tablist">
									<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Draw</button>
									<button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Upload</button>

								</div>
							</nav>
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
									<div id="my_pad">
										<div id="signature-pad" class="signature-pad">
											<div class="signature-pad--body">
												<canvas></canvas>
											</div>
											<div class="signature-pad--footer">
												<div class="description">Sign above</div>

												<div class="signature-pad--actions">
													<div>
														<button type="button"  class="button clear" data-action="clear">Clear</button>

														<button type="button" class="button" data-action="undo">Undo</button>
													</div>

												</div>
											</div>
										</div>
									</div>
									
								</div>
								<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
									<div class="input-group" style="margin-top:20px;">
										<input type="file" class="form-control" id="signature_file_input" onchange="previewFile(this);" accept="image/*" style="border-color:rgb(206, 212, 218);background-image:none">
										
									</div>

									<img id="previewImg" src="" class="img-fluid img-thumbnail" style="max-width:230px;display:none;margin-top:20px;border-color:none;background-image:none" >	
								</div>
								<span class="redhide signature_msg">Please provide a valid Signature</span>
							</div>			
							
						</div>
						<div class="col-md-12 text-right mt-3">
							<button id="save_signature_btn" type="submit" name="submit" style="float:right" class="btn btn-primary  pull-right"><i class="fa fa-pencil-square-o"></i> Save Signature</button>
							<div id="save_signature_loader" >			
								<div class="d-flex align-items-center">
									<div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
									<span class="spinner-text">Saving your signature</span>
								</div>
							</div>				
							
						</div>
						<!-- <a class="m-btn blue-button complate_job_costing disabled" href="javascript:void(0)" style="position: relative; margin:10px 0px" >Complete Job Costing</a> -->

					</div>

					</form>
				</div>
			</div>




			<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight2" aria-labelledby="offcanvasRightLabel">
				<div class="offcanvas-header">
					<legend class="text-left">Images</legend>
					<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body" style="border-top:1px solid #ccc">
				<div id="proposalCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
							<div class="carousel-inner" style="width:100%; height: 500px !important;">
								<?php
								$k = 0;
								foreach ($images2 as $image) { ?>
									<div class="carousel-item pd-top-25 slide-image-<?= $k; ?>">
										<div class="carousel-caption d-none d-md-block pd-top-0-minus ">
											<h5><?php echo $image['title'] ?></h5>
										</div>
										<img src="<?php echo $image['src']; ?>" style="height: 425px !important; object-fit: contain;" class="d-block w-100" alt="...">
										<div class="carousel-caption d-none d-md-block bottom-note">

											<p><?php echo $image['notes']; ?></p>
										</div>
									</div>

								<?php $k++;
								} ?>
							</div>

							<button class="carousel-control-prev" type="button" data-bs-target="#proposalCarousel" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#proposalCarousel" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
						</div>
				</div>
			</div>




		</div>
	</div>



	</div>
</div>

<!--Modal popup-->
<div class="modal fade" id="submitSignModal"   aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width:33%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Success</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
	  <p>Proposal Signed. We will email you a copy of the document</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="fa fa-fw fa-check-circle"></i> Ok</button>
        
      </div>
    </div>
  </div>
</div>




	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo site_url('static') ?>/js/signature/signature_pad.umd.js"></script>
	<!-- <script src="<?php echo site_url('static') ?>/js/signature/app.js"></script> -->

	<script type="text/javascript">
		$(document).ready(function() {

			


(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
		
        if (!form.checkValidity()) {
		
          event.preventDefault()
          event.stopPropagation()
        }else{
			save_signature(this)
		}
		
        form.classList.add('was-validated')
      }, false)
    })
})()










			var sectionIds = $('a.sep-link');

			$(document).scroll(function() {
				sectionIds.each(function() {

					var container = $(this).attr('href');
					if (container.startsWith("#")) {
						if ($(container).offset()) {
							var containerOffset = $(container).offset().top;
						} else {
							var containerOffset = 0;
						}

						var containerHeight = $(container).outerHeight();
						var containerBottom = containerOffset + containerHeight;
						var scrollPosition = $(document).scrollTop();

						if (scrollPosition < containerBottom && scrollPosition >= containerOffset) {
							$(this).addClass('active');
						} else {
							$(this).removeClass('active');
						}
					}


				});
			});

			

			$(document).on("click", ".closeProposalSignature", function() {
				$('.doc-section').show();
				$('.proposalSignature').hide();
				$('html, body').animate({
					scrollTop: $("#signature").offset().top
				}, 100);

			})

			$(document).on("click", ".showProposalCarousel", function() {
				var slide_id = $(this).attr('data-slide');
				$('.carousel-item').removeClass('active');
				$('.' + slide_id).addClass('active');
				
			})

			$(document).on("click", ".closeProposalCarousel", function() {
				$('.doc-section').show();
				$('.proposalCarousel').hide();
				$('.closeProposalCarousel').hide();
				$('html, body').animate({
					scrollTop: $("#images").offset().top
				}, 0);
			})

			$(document).on("click", ".sidebar-close", function() {
				$('#navbar-example3').addClass('hide-sidebar');

				//$('#navbar-example3').hide();
				$('.openbtn').show();
				$('#navbar-example3').hide();
				//$('.openbtn').show("slide", { direction: "right" }, 1000);
				$('.doc-section').addClass('col-md-12');
				$('.doc-section').removeClass('col-md-9');

				$('.proposalCarousel').addClass('col-md-12');
				$('.proposalCarousel').removeClass('col-md-9');

			})
			$(document).on("click", ".openbtn", function() {
				$('#navbar-example3').removeClass('hide-sidebar');
				//$('#navbar-example3').show();
				$('.openbtn').hide();
				$('.doc-section').removeClass('col-md-12');
				$('.doc-section').addClass('col-md-9');
				$('#navbar-example3').show("slide", {
					direction: "left"
				}, 1000);
				//$('.openbtn').hide("slide", { direction: "left" }, 1000);

				$('.proposalCarousel').removeClass('col-md-12');
				$('.proposalCarousel').addClass('col-md-9');
			})



			var wrapper = document.getElementById("signature-pad");
			var clearButton = wrapper.querySelector("[data-action=clear]");
			var changeColorButton = wrapper.querySelector("[data-action=change-color]");
			var undoButton = wrapper.querySelector("[data-action=undo]");
			var savePNGButton = wrapper.querySelector("[data-action=save-png]");
			var saveJPGButton = wrapper.querySelector("[data-action=save-jpg]");
			var saveSVGButton = wrapper.querySelector("[data-action=save-svg]");
			var canvas = wrapper.querySelector("canvas");
			var signaturePad = new SignaturePad(canvas, {
				// It's Necessary to use an opaque color when saving image as JPEG;
				// this option can be omitted if only saving as PNG or SVG
				backgroundColor: 'rgb(255, 255, 255)'
			});

			// Adjust canvas coordinate space taking into account pixel ratio,
			// to make it look crisp on mobile devices.
			// This also causes canvas to be cleared.
			function resizeCanvas() {
				// When zoomed out to less than 100%, for some very strange reason,
				// some browsers report devicePixelRatio as less than 1
				// and only part of the canvas is cleared then.
				var ratio = Math.max(window.devicePixelRatio || 1, 1);
				// This part causes the canvas to be cleared
				canvas.width = canvas.offsetWidth * ratio;
				canvas.height = canvas.offsetHeight * ratio;
				//canvas.height = 150;
				canvas.getContext("2d").scale(ratio, ratio);

				// This library does not listen for canvas changes, so after the canvas is automatically
				// cleared by the browser, SignaturePad#isEmpty might still return false, even though the
				// canvas looks empty, because the internal data of this library wasn't cleared. To make sure
				// that the state of this library is consistent with visual state of the canvas, you
				// have to clear it manually.
				signaturePad.clear();
			}

			// On mobile devices it might make more sense to listen to orientation change,
			// rather than window resize events.
			window.onresize = resizeCanvas;
			resizeCanvas();

			function download(dataURL, filename) {
				if (navigator.userAgent.indexOf("Safari") > -1 && navigator.userAgent.indexOf("Chrome") === -1) {
					window.open(dataURL);
				} else {
					var blob = dataURLToBlob(dataURL);
					var url = window.URL.createObjectURL(blob);

					var a = document.createElement("a");
					a.style = "display: none";
					a.href = url;
					a.download = filename;

					document.body.appendChild(a);
					a.click();

					window.URL.revokeObjectURL(url);
				}
			}

			// One could simply use Canvas#toBlob method instead, but it's just to show
			// that it can be done using result of SignaturePad#toDataURL.
			function dataURLToBlob(dataURL) {
				// Code taken from https://github.com/ebidel/filer.js
				var parts = dataURL.split(';base64,');
				var contentType = parts[0].split(":")[1];
				var raw = window.atob(parts[1]);
				var rawLength = raw.length;
				var uInt8Array = new Uint8Array(rawLength);

				for (var i = 0; i < rawLength; ++i) {
					uInt8Array[i] = raw.charCodeAt(i);
				}

				return new Blob([uInt8Array], {
					type: contentType
				});
			}

			clearButton.addEventListener("click", function(event) {
				signaturePad.clear();
			});

			undoButton.addEventListener("click", function(event) {
				var data = signaturePad.toData();

				if (data) {
					data.pop(); // remove the last dot or line
					signaturePad.fromData(data);
				}
			});
			$("#clientSignatureForm").submit(function(ev){ev.preventDefault();});



			function save_signature(e){
				var dataURL = false;
			if (signaturePad.isEmpty()) {
					
					if( document.getElementById("signature_file_input").files.length == 0 ){
						$('.signature_msg').show();
					}else{
						var dataURL = $('#signature_url').val();
					}

				} else {
					$('.signature_msg').hide();
					
					var dataURL = signaturePad.toDataURL();
					$('#signature_url').val(dataURL);
				}
				if(dataURL){
					$('#save_signature_loader').css('display', 'inline-block');
					var signature_title = $('#signature_title').val();
					var signature_firstname = $('#signature_firstname').val();
					var signature_lastname = $('#signature_lastname').val();
					var signature_company = $('#signature_company').val();
					var signature_email = $('#signature_email').val();
					var proposal_id = $('#proposal_id').val();
					var signature_comments = $('#signature_comments').val();

					
					$.ajax({
						url: '<?php echo site_url('ajax/client_signature_form_submit') ?>',
						type: "POST",
						data: {
							"signature": dataURL,
							"signature_title": signature_title,
							"signature_firstname": signature_firstname,
							"signature_lastname": signature_lastname,
							"signature_company": signature_company,
							"signature_email": signature_email,
							"proposal_id": proposal_id,
							"signature_comments": signature_comments,

						},
						dataType: "json",
						success: function(data) {
							if (data.success) {

								$('#submitSignModal').modal('show');
								//refresh frame
								$('.client_signature_td').html('');
								$('.client_signature_td').html('<img style="width: auto; height: 70px;" src="' + data.src + '">')

								$('#signed_span').html('Signed : '+ data.signed);
								jQuery('#offcanvasRight').offcanvas('hide');
							} else {
								if (data.error) {
									alert("Error: " + data.error);
								} else {
									alert('An error has occurred. Please try again later!')
								}
							}
						}
					});
				}
		}
		});

		function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
				$("#signature_url").val(reader.result);
            }
			$("#previewImg").show()
            reader.readAsDataURL(file);
        }
    }


	</script>
</body>

</html>
<?php die; ?>
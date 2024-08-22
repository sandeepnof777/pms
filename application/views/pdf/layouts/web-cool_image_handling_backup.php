<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	$headerFont = $proposal->getClient()->getCompany()->getCoolHeaderFont();
	$bodyFont = $proposal->getClient()->getCompany()->getCoolTextFont();
	?>
	<meta charset="utf-8">
	<!--  This file has been downloaded from bootdey.com    @bootdey on twitter -->
	<!--  All snippets are MIT license http://bootdey.com/license -->
	<title><?php echo $proposal->getProjectName()  ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo site_url('static') ?>/css/signature-pad.css">
	<link rel="stylesheet" href="<?php echo site_url('3rdparty/fontawesome/css/font-awesome.min.css') ?>">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo site_url('static') ?>/css/proposal.css">
	<style type="text/css">
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
		@media print {
  .page_break{page-break-after: always;}
  nav{display:none!important;}
  .sidebar-close{display:none!important;}
  #print_header{
	display:block!important;
    position: fixed;
    top: 0;
	z-index: 1;

  }
  .break-before {display: block;
    page-break-before: always;
    position: relative;}
  .no-header-element{
   position: relative;
   z-index: 1000;
	}
	.print_hide{
		display:none;
	}
	.avoid-break{page-break-inside: avoid;}
}
	</style>
</head>

<body>
	<?php
	$s = array('$', ',');
	$r = array('', '');
	?>
	
	<div class="container-fluid">
		<button type="button" class="btn btn-dark openbtn" aria-label="Close"><i class="fa fa-chevron-right sidebar-btn-icon"></i></button>
		<div class="row">

			<nav class="col-md-3 nav " id="navbar-example3">
				<button type="button" class="btn btn-dark sidebar-close" aria-label="Close"><i class="fa fa-chevron-left sidebar-btn-icon"></i></button>
				<div class="flex-shrink-0 p-3 bg-white sticky-sidebar scrollbar-primary">
					<a href="#" class="d-flex align-items-center pb-3 link-dark text-decoration-none border-bottom">

						<span class="fs-5 fw-semibold">Table of Contents</span>

					</a>


					<ul class="list-unstyled ps-0 list-group-striped">
						<li class="mb-1"><a href="#title-page" class="btn sep-link align-items-center rounded">Cover Page</a></li>
						<li class="mb-1"><a href="#service-provider" class="btn sep-link align-items-center rounded">Service Provider Information</a></li>
						<li class="mb-1"><a href="#about-us-page" class="btn sep-link align-items-center rounded">About Us</a></li>
						<?php
						if ($proposal->getAuditKey()) { ?>
							<li class="mb-1"><a href="#audit-section" class="btn sep-link align-items-center rounded">Property Inspection/Audit</a></li>
						<?php } ?>
						<li class="mb-1 ">
							<button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
								Proposal Services
							</button>
							<div class="collapse" id="home-collapse">
								<ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
									<?php foreach ($services as $service) { ?>
										<li><a href="#service_<?= $service->getServiceId(); ?>" class="btn sep-link rounded"><?php echo $service->getServiceName() ?></a></li>
									<?php } ?>

								</ul>
							</div>
						</li>
						<?php if (count($images)) { ?>
							<li class="mb-1"><a href="#images" class="image_section_btn btn sep-link align-items-center rounded">Proposal Images</a></li>

						<?php
						}

						if ($proposal->getVideoURL() <> '') {
						?>

							<li class="mb-1"><a href="#video" class="video_section_btn btn sep-link align-items-center rounded">Proposal Video</a></li>
						<?php } ?>
						<li class="mb-1"><a href="#price-breakdown" class="btn sep-link align-items-center rounded">Price Breakdown</a></li>
						<li class="mb-1"><a href="#signature" class="btn sep-link align-items-center rounded">Payment Terms</a></li>


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
				
			
			<!-- BEGIN INVOICE -->
			<div class="boxed-section" id="boxed-section">
			<?php
				$pdf_layout = 'cool';
				if ($proposal->getLayout()) {
					$pdf_layout = $proposal->getLayout();
				} else {
					if ($proposal->getOwner()->getLayout()) {
						$pdf_layout = $proposal->getOwner()->getLayout();
					} else {
						$pdf_layout = $proposal->getOwner()->getCompany()->getLayout();
					}
				}

				$pdf_url = site_url('proposals/live/preview/' . $pdf_layout . '/plproposal_' . $proposal->getAccessKey() . '.pdf');
				?>
				<div class="header grid invoice print_hide" id="infoHeader" style="display:none;">
					<div class="grid-body">
						<div class="row">
							<div class="col-lg-2 col-md-12 col-sm-12 pd-t-5 pd-l-0">
								<img class="mg-left--4" src="<?php echo site_url('uploads/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo()); ?>" width="125px" height="auto" alt="">
							</div>
							<div class="col-lg-3 col-md-6 pd-t-10">
								<strong>
									<?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName();  ?>
								</strong><br />
								<span class="second_line"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName()  ?></span>

							</div>
							<div class="col-lg-3 col-md-6 pd-t-10">
								<strong><?php echo $proposal->getProjectName()  ?></strong><br />
								<span class="second_line"><?php echo $proposal->getProjectAddress() ?> <?php echo trim($proposal->getProjectCity()) . ', ' . $proposal->getProjectState() . ' ' . $proposal->getProjectZip() ?></span>
							</div>

							<div class="col-lg-4 col-md-6 col-sm-6 pd-t-10 pull-right-md">


								<button type="button" id="ask_question_open_canvas_btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight3" aria-controls="offcanvasRight" class="btn btn-primary btn-sm  pave-btn"><i class="fa fa-fw fa-download"></i> <span class="button-text">Ask Question</span></button>
								<a href="<?php echo $pdf_url; ?>" download class="btn btn-primary btn-sm mg-l-10 pave-btn"><i class="fa fa-fw fa-download"></i> <span class="button-text">Download</span></a>
							</div>
						</div>
					</div>
				</div>
			

			<div class="doc-section" style="margin-top:15px">


				
				<div id="print_header" style="display:none;">
					<h1 class="underlined global_header" style="position: fixed;">Proposal: <?php echo $proposal->getProjectName() ?></h1>
					<div class="logotopright"><img class="theLogo" style="height: 40px; width: 120px; margin-right: 8px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
				UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>" alt=""></div>


				</div>
				
				<div class="grid invoice page_break no-header-element pdf-height">
					<div class="grid-body">
						<div class="invoice-title" id="title-page">
							<div class="row">

								<div class="col-md-12">
									<h1 class="title_big"><?php echo $proposal->getProposalTitle() ?></h1>
								</div>
							</div>
							<br>
							<div class="row" style="padding-bottom: 133px">
								<div class="col-md-12">
									<img src="<?php echo site_url('uploads/separator.jpg'); ?>" width="100%">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<?php if ($proposal->getClient()->getClientAccount()->getName()) { ?>
										<h2 class="company_name" style="text-align: center;"><?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName();  ?></h2>
									<?php } ?>
									<h3 class="company_owner" style="text-align: center; padding-bottom: 102px;"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName()  ?></h3>

									<h3 class="company_owner" style="text-align: center; font-size: 15px !important; line-height: 17px; margin-bottom: 15px;">Project:</h3>

									<h3 class="company_owner" style="text-align: center; margin-bottom: 0; padding-bottom: 0; line-height: 22px;"><?php echo $proposal->getProjectName()  ?></h3>
									<?php if ($proposal->getProjectAddress()) { ?>
										<h4 style="text-align: center; margin-top: 0; padding-top: 0; font-weight: normal; font-size: 13px;"><?php echo $proposal->getProjectAddress() ?><br><?php echo $proposal->getProjectCity() . ', ' . $proposal->getProjectState() . ' ' . $proposal->getProjectZip() ?></h4>
									<?php } ?>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="issuedby pull-right">
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

				<div class="grid invoice page_break no-header-element pdf-height">
					<div>

						<div class="row" id="service-provider">
							<div class="col-md-12">
								<h1 id="service_provider_title" style="z-index: 200;text-align:center"><?php echo $proposal->getClient()->getCompany()->getPdfHeader() ?></h1>
							</div>
						</div>
						<br>
						<div class="row company_info_row">
							<div class="col-md-6" style="text-align:center">
								<h2 style="margin-bottom: 19px;">Company Info</h2>
								<img class="theLogo" src="<?php echo site_url('uploads/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo()) ?>" alt="">
								<p style="margin-block-start: 22px;"><?php echo $proposal->getClient()->getCompany()->getCompanyName() ?><br>
									<?php echo $proposal->getOwner()->getAddress() ?><br>
									<?php echo $proposal->getOwner()->getCity() ?>, <?php echo $proposal->getOwner()->getState() ?> <?php echo $proposal->getOwner()->getZip() ?><br>
									<br>
									P: <?php echo $proposal->getOwner()->getOfficePhone() ?><br>
									<?php if ($proposal->getClient()->getCompany()->getFax() || $proposal->getOwner()->getFax()) { ?>
										F: <?php echo ($proposal->getOwner()->getFax()) ? $proposal->getOwner()->getFax() : $proposal->getClient()->getCompany()->getFax() ?><br>
									<?php } ?>
									<a style="font-size: 14px;" href="<?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?>"><?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?></a><br>
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
						<div class="row" id="about-us-page">
							<h1 class="title_big_aboutus">About Us</h1>

							<p class="aboutus"><?php echo $proposal->getClient()->getCompany()->getAboutCompany() ?></p>
						</div>				
					</div>
					<div class="row page_number">Page 2</div>
				</div>
				

				<!-- END INVOICE -->
				<!-- BEGIN INVOICE -->

				<div class="grid invoice pdf-height page_break" style="padding-top: 10px;" id="audit-section">
					<div class="grid-body">
						<div class="row">
							<div class="row">
								<h1 class="underlined global_header">Proposal Services</h1>
							</div>
						</div>
						<div class="row">
							<?php


							if ($proposal->getAuditKey()) {
							?>
								<div style="page-break-inside: avoid">
									<div class="item-content audit">
										<h2>Property Inspection / Audit</h2>

										<table>
											<tr>
												<td style="text-align: center;width:25%">
													<a href="javascript:void(0)" class="openAuditIframe" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight4" aria-controls="offcanvasRight" style="display: block;float: left;">
														<img id="auditIcon" src=" <?php echo site_url('uploads/audit-icon.png'); ?>" />
													</a>
													<p style="padding-top: 19px;text-align: center; font-weight: bold; font-style: italic;margin-top: 96px;">Click to See</p>
												</td>
												<td style="font-size: 16px; ">
													<p style="margin-top: 0px;padding-top: 14px;">We have performed a custom site inspection/audit of this site including maps, images and more</p>
													<p style="padding-top: 4px;margin-top: 0px;"><a href="javascript:void(0)" class="openAuditIframe" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight4" aria-controls="offcanvasRight">View your Custom Site Inspection/Audit Report</a></p>
												</td>
											</tr>
										</table>
										<div class="audit-footer" style="margin-top: 10px;"></div>
									</div>
								</div>
								<?php    }

							$k = 0;
							foreach ($services as $service) {

								$k++;

								if (!$proposal->hasSnow()) {
								?>
									<div class="col-md-12 margin-top-bottom-10 avoid-break" id="service_<?php echo $service->getServiceId() ?>">
										<div class="item-content<?php echo ($service->isNoPrice()) ? ' no-price' : ''; ?>">
											<h2><?php echo $service->getServiceName() ?></h2>
											<div class="item-content-texts">
												<?php echo $services_texts[$service->getServiceId()]; ?>
											</div>
											<?php if (!$lumpSum  && !$service->isNoPrice()) {
												$price = (float) str_replace($s, $r, $service->getPrice());
												$taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
											?>

												<span style="padding-left: 40px;    float: left; margin-top: 7px;">Total Price: <?php echo   '$' . number_format(($price - $taxprice), 2);   ?></span>

											<?php } ?>
										</div>
									</div>
								<?php
								} else {
								?>
									<div class="col-md-12 margin-top-bottom-10 avoid-break" id="service_<?php echo $service->getServiceId() ?>" style="page-break-inside: avoid">
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
					<div class="row page_number">Page 3</div>
				</div>

				<!-- END INVOICE -->

				<?php
				$images2 = array();
				if (count($images)) { 
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
					$page=4;
					
					?>
					<!-- BEGIN INVOICE -->

					
									<?php

									
									foreach ($images2 as $image) {


										$j++;
										
										switch ($image['image_layout']) {
											case 1:

												
												if ($tableOpen) {
													if ($old_layout == 2) {
														if($imageCount==1){
															echo '</div>';	
														}
														if($imageCount % 2 == 0){
															echo '</div>';
														}else{
															echo '</div></div>';
														}
													//    //close tr's if necessary...
														
															echo '</div><div class="row page_number">Page '.$page++.'</div></div>';
														
													   //close table
													   
													   $tableOpen =0;
												   }
											   }
												//open table
												if ($old_layout !=1) {
													$imageCount = 0;
												}
												
												if (!($imageCount % 2)  ) {
													?>
													<div class="grid invoice pdf-height page_break 1con" style="padding-top: 10px;" <?php if($j==1){echo ' id="images"';}?> >
														<div class="grid-body">
														<?php if($j==1){?>	
															<div class="row">
																<div class="row">
																	<h1 class="underlined global_header">Proposal Images</h1>
																</div>
															</div>
															<?php }?>

															<div class="row">

																<div class="" id="gallery" data-toggle="modal" data-target="#exampleModal">
												<?php	$tableOpen = 1;
												}
												//display image
												?>
												
													<div class="col-12 col-sm-12 col-md-12 mg-btm-20 break-before con322">
														<h2 style="text-align: center;"><?php echo $image['title'] ?></h2>
														<img data-slide="slide-image-<?= $j; ?>" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight2" aria-controls="offcanvasRight" class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?> img-fluid img-thumbnail btn showProposalCarousel" style="object-fit: cover; height:auto;width:100%;" src="<?php echo $image['src']; ?>" alt="">
														<h2 style="text-align: center;margin-top: 10px;">Notes:</h2>
														<div style="text-align: left;"><?php echo $image['notes']; ?></div><br>
													</div>
												<?php
												//increment counter
												$imageCount++;
												//close table
												if ($imageCount % 2 == 0) {
													?>
													</div></div></div><div class="row page_number">Page <?=$page++?></div></div>
													<?php
													$tableOpen = 0;
												}
												break;
											case 2:
								
												
												if ($tableOpen) {
													if ($old_layout == 1) {
															if ($imageCount % 2) {
															 echo '</div></div></div>';
														 }
													   //close table
														echo '<div class="row page_number">Page '.$page++.'</div></div>';
														$tableOpen =0;
													} else {
													
												   }
											   }
											   if ($old_layout !=2) {
													$imageCount = 0;
												 }
												// //open table
												 if (!($imageCount % 4)) {
													?>
													<div class="grid invoice pdf-height page_break 2ncon" style="padding-top: 10px;" <?php if($j==1){echo ' id="images"';}?> >
														<div class="grid-body">
														<?php if($j==1){?>	
															<div class="row">
																<div class="row">
																	<h1 class="underlined global_header">Proposal Images</h1>
																</div>
															</div>
															<?php }?>

															<div class="row">

																<div class="" id="gallery" data-toggle="modal" data-target="#exampleModal">
													<?php
													$tableOpen = 1;
												}
												//display image
											if (!($imageCount % 2)) {
												?>
												<div class="row">
											<?php
											}
								
												?>
												
												<div class="col-12 col-sm-6 col-md-6 mg-btm-20 break-before">
														<h2 style="text-align: center;"><?php echo $image['title'] ?></h2>
														<img data-slide="slide-image-<?= $j; ?>" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight2" aria-controls="offcanvasRight" class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?> img-fluid img-thumbnail btn showProposalCarousel" style="object-fit: cover; height:280px; width:100%;" src="<?php echo $image['src']; ?>" alt="">
														<h2 style="text-align: center;margin-top: 10px;">Notes:</h2>
														<div style="text-align: left;"><?php echo $image['notes']; ?></div><br>
													</div>
												<?php
								
								
											if ($imageCount % 2) {
												?>
												</div></div>
											<?php
											}
												//increment counter
												$imageCount++;
												//close table
												if ($imageCount % 4 == 0) {
													?>
													</div><div class="row page_number">Page <?=$page++;?></div></div>
													<?php
													$tableOpen = 0;
												}
												break;
											default: //1 image per page
											if ($tableOpen) {
											 //echo $old_layout;
												
												if ($old_layout != 0) {
													
												   //close table
												   // echo '</table>';
												
												   //close tr's if necessary...
													// if ($imageCount % 2) {
													//     echo '<td></td></tr>';
													// }
													if ($old_layout == 2 ) {
														//echo $imageCount;
														if(($imageCount % 4) != 2){
														   //echo 'test';die;
															echo '</div></div></div>';
															$tableOpen =0;
														}else{
															//echo '</div>9';
															$tableOpen =0;
															if(count($images2) != $j){
															   // echo '</table>';
															}
															
														}
													   
													}else if($old_layout == 1){
														if ($imageCount % 2) {
																 echo '</div></div>';
															 }
															
														}
														if($image['image_layout']==0){
															echo '</div>';
														}
														echo '<div class="row page_number">Page '.$page++.'</div></div>';
														
														$tableOpen =0;
												   //close table
												  
												   //echo 'test3';die;
											   }
											   //echo '<div style="page-break-after: always"></div>';
										   }
									   
												?>
												<div class="grid invoice pdf-height page_break 1con" style="padding-top: 10px;" <?php if($j==1){echo ' id="images"';}?> >
														<div class="grid-body">
														<?php if($j==1){?>	
															<div class="row">
																<div class="row">
																	<h1 class="underlined global_header">Proposal Images</h1>
																</div>
															</div>
															<?php }?>

															<div class="row">

																<div class="" id="gallery" data-toggle="modal" data-target="#exampleModal">

													<div class="col-12 col-sm-12 col-md-12 mg-btm-20 break-before con234234">
														<h2 style="text-align: center;"><?php echo $image['title'] ?></h2>
														<img data-slide="slide-image-<?= $j; ?>" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight2" aria-controls="offcanvasRight" class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?> img-fluid img-thumbnail btn showProposalCarousel" style="object-fit: cover; height:auto; width:100%;" src="<?php echo $image['src']; ?>" alt="">
														<h2 style="text-align: center;margin-top: 10px;">Notes:</h2>
														<div style="text-align: left;"><?php echo $image['notes']; ?></div><br>
													</div>
													</div>
												</div>
													</div>
													<div class="row page_number">Page <?=$page++?></div>
													</div>	
												<?php
												break;
										}
										$old_layout = $image['image_layout'];


									}//new end

									if ($tableOpen) {
										if ($old_layout == 1) {
										   //close table
										   echo '</div></div></div><div class="row page_number">Page '.$page++.'</div></div>';
										} else {
										   //close tr's if necessary...
											if ($imageCount % 2) {
												echo '</div></div>';
											}
										   //close table
										   echo '<div></div></div></div><div class="row page_number">Page '.$page++.'</div></div>';
									   }
								   } ?>



								
										
									
								
				<?php } ?>


				<!-- END INVOICE -->

				<!-- BEGIN INVOICE -->
				<?php
				if ($proposal->getVideoURL() <> '') {
					$buttonShow = false;

					$url = $proposal->getVideoURL();
					$finalUrl = '';
					if (strpos($url, 'facebook.com/') !== false) {
						//it is FB video
						$finalUrl .= 'https://www.facebook.com/plugins/video.php?href=' . rawurlencode($url) . '&show_text=1&width=200';
					} else if (strpos($url, 'vimeo.com/') !== false) {
						//it is Vimeo video
						$videoId = explode("vimeo.com/", $url)[1];
						if (strpos($videoId, '&') !== false) {
							$videoId = explode("&", $videoId)[0];
						}
						$finalUrl .= 'https://player.vimeo.com/video/' . $videoId;
					} else if (strpos($url, 'youtube.com/') !== false) {
						if (strpos($proposal->getVideoURL(), 'embed') > 0) {
							$finalUrl = $proposal->getVideoURL();
						} else {
							//it is Youtube video
							$videoId = explode("v=", $url)[1];
							if (strpos($videoId, '&') !== false) {
								$videoId = explode("&", $videoId)[0];
							}
							$finalUrl .= 'https://www.youtube.com/embed/' . $videoId;
						}
					} else if (strpos($url, 'youtu.be/') !== false) {
						//it is Youtube video
						$videoId = explode("youtu.be/", $url)[1];
						if (strpos($videoId, '&') !== false) {
							$videoId = explode("&", $videoId)[0];
						}
						$finalUrl .= 'https://www.youtube.com/embed/' . $videoId;
					} else if (strpos($url, 'screencast.com/') !== false) {
						$finalUrl = $proposal->getVideoURL();
					} else if (strpos($proposal->getVideoURL(), 'dropbox.com') !== false) {
						$finalUrl = str_replace('dl=0', 'raw=1', $proposal->getVideoURL());
					} else {
						$buttonShow = true;
						$finalUrl = $proposal->getVideoURL();
					}
				?>
					<div class="grid invoice print_hide" style="padding-top: 10px;" id="video">
						<div class="grid-body">
							<div class="row">
								<div class="row">	
									<h1 class="underlined global_header">Proposal Video</h1>
								</div>
							</div>
							<div class="row">

								<?php if ($buttonShow) { ?>
									<a href="<?php echo $url; ?>" class="btn btn-primary" style="width:150px;" target="_blank">Proposal Video</a>
								<?php } else { ?>
									<div class="embed-responsive embed-responsive-16by9 video">
										<?php if ($proposal->getThumbImageURL()) { ?>
											<img src="<?= $proposal->getThumbImageURL(); ?>" style="padding-left:10px;padding-right:12px">
											<div class="play-overlay">
												<a href="javascript:void(0)" class="play-icon">
													<i class="fa fa-play"></i>
												</a>
											</div>
											<!-- <iframe class="embed-responsive-item" src="<?php echo $finalUrl . '?autoplay=1'; ?>"
                                            allowfullscreen loading="lazy" allow="autoplay"></iframe> -->
										<?php } else { ?>
											<iframe class="embed-responsive-item" src="<?php echo $finalUrl; ?>" allowfullscreen loading="lazy"></iframe>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="row page_number">Page <?=$page++?></div>
					</div>
				<?php } ?>
				<!-- END INVOICE -->
				<!-- BEGIN INVOICE -->

				<div class="grid invoice pdf-height page_break " style="padding-top: 10px;" id="price-breakdown">
					<div class="grid-body">
						<div class="row">
							<div class="row">
								<h1 class="underlined global_header">Price Breakdown</h1>
							</div>
						</div>
						<div class="row">
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
								<div class="table-container ">
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
									<h2 class="mg-t-4">Optional Services:</h2>
									<div class="table-container ">
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
								<div class="table-container table_mg-t-2">
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
								<h2 style="margin: 7px 0px 17px 0px">Authorization to Proceed & Contract</h2>
								<p style="padding: 0; margin: 0;"><?php echo ($proposal->getContractCopy()) ? $proposal->getContractCopy() : $proposal->getClient()->getCompany()->getContractCopy() ?></p>
							<?php }
							?>
						</div>
					</div>
					<div class="row page_number">Page <?=$page++?></div>
				</div>

				<!-- END INVOICE -->
				<!-- BEGIN INVOICE -->

				<div class="grid invoice pdf-height page_break" style="padding-top: 10px;" id="signature">
					<div class="grid-body">
						<div class="row">
							<div class="row">
								<h1 class="underlined global_header">Payment Terms</h1>
							</div>
						</div>
						<div class="row">



							<div style="page-break-inside: avoid">


								<p style="padding: 0; margin: 0;"><?php echo ($proposal->getPaymentTerm() == 0) ? 'We agree to pay the total sum or balance in full upon completion of this project.' : 'We agree to pay the total sum or balance in full ' . $proposal->getPaymentTerm() . ' days after the completion of work.'; ?></p><br />

								<!--Dynamic Section-->
								<?php
								echo ($proposal->getPaymentTermText()) ? $proposal->getPaymentTermText() : $proposal->getOwner()->getCompany()->getPaymentTermText();
								?>
								<!--The signature and stuff-->

								<table border="0" class="mg-t-22 mg-l-11">
									<tr>
										<td width="30">Date:</td>
										<td width="200" style="border-bottom: 2px solid #000;">&nbsp;</td>
									</tr>
								</table>


								<?php
								if (!file_exists(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg') || $companySig) {
									echo '<br />';
								}
								?>

								<table border="0" class="mg-l-11 mg-t-11" style="width:100%">
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
										<td valign="top" width="220" style="line-height: 1.35;padding-top:7px">
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
											} else {
												echo '<br><span id="signed_span"></span>';
											}
											?><br>
										</td>
										<td width="65"></td>
										<td valign="top" width="220" style="line-height: 1.35;padding-top:7px">

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
					<div class="row page_number">Page <?=$page++?></div>
				</div>
				<!-- END INVOICE -->
				<?php

				if (count($specs)) { ?>
					<!-- BEGIN INVOICE -->

					<div class="grid invoice pdf-height page_break" style="padding-top: 10px;">
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
						<div class="row page_number">Page <?=$page++?></div>
					</div>
				<?php } ?>

				<!-- END INVOICE -->





				<?php
				if ($havetexts) { ?>
					<!-- BEGIN INVOICE -->

					<div class="grid invoice pdf-height page_break" style="padding-top: 10px;">
						<div class="grid-body">
							<div class="row">
								<div class="row">
									<h1 class="underlined global_header">Additional Info</h1>
								</div>
							</div>
							<div class="row">
								<?php
								foreach ($proposal_categories as $catId => $on) {
									if ($on && isset($categories[$catId])) {
										$cat = $categories[$catId];
										if (count($cat['texts'])) {
								?>
											<h2 class="margin-bottom-17" id="custom_text_<?= $catId; ?>"><?php echo $cat['name'] ?></h2>
											<ol class="margin-left-38 margin-bottom-10 li-m-b-6">
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
						<div class="row page_number">Page <?=$page++?></div>
					</div>
				<?php } ?>
				<!-- END INVOICE -->
				<?php
				if ($proposal->getInventoryReportUrl()) { ?>
					<!-- BEGIN INVOICE -->

					<div class="grid invoice pdf-height page_break" style="padding-top: 10px;">
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
						<div class="row page_number">Page <?=$page++?></div>
					</div>
					<!-- END INVOICE -->
					<?php
					// Do we have inventory Data
					if ($inventoryData) {
						if (count($inventoryData->data->breakdown)) { ?>
							<!-- BEGIN INVOICE -->

							<div class="grid invoice pdf-height page_break" style="padding-top: 10px;">
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
								<div class="row page_number">Page <?=$page++?></div>
							</div>
						<?php
						} ?>
						<!-- END INVOICE -->
						<?php if (count($inventoryData->data->totals)) { ?>
							<!-- BEGIN INVOICE -->

							<div class="grid invoice pdf-height page_break" style="padding-top: 10px;">
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
								<div class="row page_number">Page <?=$page++?></div>
							</div>
						<?php
						} ?>
						<!-- END INVOICE -->
						<?php if (count($inventoryData->data->zoneItems)) { ?>
							<!-- BEGIN INVOICE -->

							<div class="grid invoice pdf-height page_break" style="padding-top: 10px;">
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
								<div class="row page_number">Page <?=$page++?></div>
							</div>
						<?php
						} ?>
						<!-- END INVOICE -->
						<?php if (count($inventoryData->data->zoneItemTotals)) {
						?>
							<!-- BEGIN INVOICE -->

							<div class="grid invoice pdf-height page_break" style="padding-top: 10px;">
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
								<div class="row page_number">Page <?=$page++?></div>
							</div>
				<?php
						}
					}
				}
				?>
				<!-- END INVOICE -->

			</div>

</div>




			<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
				<div class="offcanvas-header">
					<legend class="text-left">Add Signature : <?php echo $proposal->getProposalTitle() ?></legend>
					<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					<form id="clientSignatureForm" onsubmit="return false;" class="g-3 needs-validation" novalidate>
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
										if ($clientSig) {
											$client_names = explode(" ", $clientSig->getName());
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
										<input type="text" required name="company" class="form-control" value="<?php echo ($clientSig) ? $clientSig->getCompanyName() : $proposal->getClient()->getClientAccount()->getName(); ?>" id="signature_company" placeholder="Enter Company Name">
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
									<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required name="email" class="form-control" value="<?php echo ($clientSig) ? $clientSig->getEmail() : $proposal->getClient()->getEmail(); ?>" id="signature_email" placeholder="Enter Email">
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
															<button type="button" class="button clear" data-action="clear">Clear</button>

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

										<img id="previewImg" src="" class="img-fluid img-thumbnail" style="max-width:230px;display:none;margin-top:20px;border-color:none;background-image:none">
									</div>
									<span class="redhide signature_msg">Please provide a valid Signature</span>
								</div>

							</div>
							<div class="col-md-12 text-right mt-3">
								<button id="save_signature_btn" type="submit" name="submit" style="float:right" class="btn btn-primary  pull-right"><i class="fa fa-pencil-square-o"></i> Save Signature</button>
								<div id="save_signature_loader">
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
							$k = 1;
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


			<!-- ask question offcanvas-->
			<div class="offcanvas offcanvas-end offcanvas-410" tabindex="-1" id="offcanvasRight3" aria-labelledby="offcanvasRightLabel">
				<div class="offcanvas-header">
					<legend class="text-left pave-text-color">Ask Question : <?php echo $proposal->getProposalTitle() ?></legend>
					<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					<form id="clientSignatureForm" onsubmit="return false;" class="g-3 needs-validation2" novalidate>
						<div class="row">

							<hr />

							<div class="col-md-12">
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="ask_question_firstname" class="form-label">First Name</label>
										<?php
										if ($clientSig) {
											$client_names = explode(" ", $clientSig->getName());
											$client_firstname = @$client_names[0];
											$client_lastname = @$client_names[1];
										}

										?>
										<input type="text" required name="ask_question_firstname" class="form-control" value="<?php echo ($clientSig) ? $client_firstname : $proposal->getClient()->getFirstName(); ?>" id="ask_question_firstname" placeholder="Enter First Name">
										<div class="invalid-feedback"> Please enter First Name</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="ask_question_lastname" class="form-label">Last Name</label>
										<input type="text" required name="lastname" class="form-control" value="<?php echo ($clientSig) ? $client_lastname : $proposal->getClient()->getLastName(); ?>" id="ask_question_lastname" placeholder="Enter Last Name">
										<div class="invalid-feedback"> Please enter Last Name</div>

									</div>
								</div>
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="ask_question_company" class="form-label">Company Name</label>
										<input type="text" required name="ask_question_company" class="form-control" value="<?php echo ($clientSig) ? $clientSig->getCompanyName() : $proposal->getClient()->getClientAccount()->getName(); ?>" id="ask_question_company" placeholder="Enter Company Name">
										<div class="invalid-feedback"> Please enter Company Name</div>

									</div>
									<div class="col-md-6 mb-3">
										<label for="ask_question_title" class="form-label">Title</label>
										<input type="text" required name="ask_question_title" class="form-control" value="<?php echo ($clientSig) ? $clientSig->getTitle() : $proposal->getClient()->getTitle(); ?>" id="ask_question_title" placeholder="Enter Title">
										<div class="invalid-feedback"> Please enter Title</div>
										<input type="hidden" id="ask_question_proposal_id" name="ask_question_proposal_id" value="<?= $proposal->getProposalId(); ?>">

									</div>

								</div>
								<div class="mb-3">
									<label for="ask_question_email" class="form-label">Email</label>
									<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required name="ask_question_email" class="form-control" value="<?php echo ($clientSig) ? $clientSig->getEmail() : $proposal->getClient()->getEmail(); ?>" id="ask_question_email" placeholder="Enter Email">
									<div class="invalid-feedback"> Please enter a valid Email</div>

								</div>
								<div class="mb-3">
									<label for="ask_question" class="form-label">Question</label>
									<textarea class="form-control" id="ask_question" rows="4" placeholder="Enter Question"></textarea>
								</div>

							</div>



							<div class="col-md-12 text-right mt-3">
								<button id="ask_question_btn" type="submit" name="submit" class="btn btn-primary pave-btn pull-right"><i class="fa fa-pencil-square-o"></i> Ask Question</button>
								<div id="ask_question_loader">
									<div class="d-flex align-items-center">
										<div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
										<span class="spinner-text">Sending Question</span>
									</div>
								</div>

							</div>

						</div>

					</form>
				</div>
			</div>
			<!-- end ask question offcanvas-->

			<!-- old ask question offcanvas-->
			<div class="offcanvas offcanvas-end offcanvas-410" tabindex="-1" id="offcanvasRight-old" aria-labelledby="offcanvasRightLabel">
				<div class="offcanvas-header">
					<legend class="text-left pave-text-color">Ask Question : <?php echo $proposal->getProposalTitle() ?></legend>
					<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					<form id="clientSignatureForm" onsubmit="return false;" class="g-3 needs-validation2" novalidate>
						<div class="row">

							<hr />

							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="ask_question_firstname" class="form-label">First Name</label>
										<?php
										if ($clientSig) {
											$client_names = explode(" ", $clientSig->getName());
											$client_firstname = @$client_names[0];
											$client_lastname = @$client_names[1];
										}

										?>
										<input type="text" required name="ask_question_firstname" class="form-control" value="<?php echo ($clientSig) ? $client_firstname : $proposal->getClient()->getFirstName(); ?>" id="ask_question_firstname" placeholder="Enter First Name">
										<div class="invalid-feedback"> Please enter First Name</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="ask_question_lastname" class="form-label">Last Name</label>
										<input type="text" required name="lastname" class="form-control" value="<?php echo ($clientSig) ? $client_lastname : $proposal->getClient()->getLastName(); ?>" id="ask_question_lastname" placeholder="Enter Last Name">
										<div class="invalid-feedback"> Please enter Last Name</div>

									</div>
								</div>
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="ask_question_company" class="form-label">Company Name</label>
										<input type="text" required name="ask_question_company" class="form-control" value="<?php echo ($clientSig) ? $clientSig->getCompanyName() : $proposal->getClient()->getClientAccount()->getName(); ?>" id="ask_question_company" placeholder="Enter Company Name">
										<div class="invalid-feedback"> Please enter Company Name</div>

									</div>
									<div class="col-md-6 mb-3">
										<label for="ask_question_title" class="form-label">Title</label>
										<input type="text" required name="ask_question_title" class="form-control" value="<?php echo ($clientSig) ? $clientSig->getTitle() : $proposal->getClient()->getTitle(); ?>" id="ask_question_title" placeholder="Enter Title">
										<div class="invalid-feedback"> Please enter Title</div>
										<input type="hidden" id="ask_question_proposal_id" name="ask_question_proposal_id" value="<?= $proposal->getProposalId(); ?>">

									</div>

								</div>
								<div class="mb-3">
									<label for="ask_question_email" class="form-label">Email</label>
									<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required name="ask_question_email" class="form-control" value="<?php echo ($clientSig) ? $clientSig->getEmail() : $proposal->getClient()->getEmail(); ?>" id="ask_question_email" placeholder="Enter Email">
									<div class="invalid-feedback"> Please enter a valid Email</div>

								</div>

							</div>
							<div class="col-md-6">

								<div class="mb-3">
									<label for="ask_question" class="form-label">Question</label>
									<textarea class="form-control" id="ask_question" rows="7" placeholder="Enter Question"></textarea>
								</div>
							</div>


							<div class="col-md-12 text-right mt-3">
								<button id="ask_question_btn" type="submit" name="submit" class="btn btn-primary pave-btn mg-left-70"><i class="fa fa-pencil-square-o"></i> Ask Question</button>
								<div id="ask_question_loader">
									<div class="d-flex align-items-center">
										<div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
										<span class="spinner-text">Sending Question</span>
									</div>
								</div>

							</div>

						</div>

					</form>
				</div>
			</div>
			<!-- end ask question offcanvas-->
			<!-- ask question offcanvas-->
			<?php
			if ($proposal->getAuditKey()) { ?>
				<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight4" aria-labelledby="offcanvasRightLabel">

					<span class="canvas-back-btn"><button type="button" class="btn btn-primary btn-sm  pave-btn" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa fa-fw fa-chevron-left"></i></button></span>
					<span class="canvas-back-right-btn"><button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></span>
					<div class="offcanvas-body pad-top-0">
						<div class="row">
							<div id="audit_iframe_loader">
								<div class="d-flex align-items-center">
									<div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
									<span class="spinner-text">Loading </span>
								</div>
							</div>
							<iframe id="auditIframe" class="embed-responsive-item full-height" data-src="<?php echo $proposal->getAuditReportUrl(true); ?>" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			<?php } ?>
			<!-- end ask question offcanvas-->



		</div>
	</div>



	</div>
	</div>

	<!--Signature submit Modal popup-->
	<div class="modal fade" id="submitSignModal" aria-hidden="true">
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

	<!--Ask Question Modal popup-->
	<div class="modal fade" id="submitAskQuestionModal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" style="width:33%">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Success</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Your Question successfully sent to User</p>
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
		var site_url = '<?php echo site_url() ?>';
		var nosidebar = 0;
		$(function() {
			var videos = $(".video");

			videos.on("click", function() {
				var elm = $(this),
					conts = elm.contents(),
					le = conts.length,
					ifr = null;

				for (var i = 0; i < le; i++) {
					if (conts[i].nodeType == 8) ifr = conts[i].textContent;
				}

				elm.addClass("player").html(ifr);
				elm.off("click");
			});
		});
	</script>
	<script src="<?php echo site_url('static') ?>/js/preview-proposal.js"></script>

</body>

</html>
<?php die; ?>
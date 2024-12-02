<?php 
//Databse Connection file
include('dbconnection.php');  
$ret=mysqli_query($con,"SELECT COUNT(*) AS total_users FROM users_information");
$rowe = $ret->fetch_assoc();
include('header.php');
?>
<link rel="stylesheet" href="css/swiper.css" />

<script type="text/javascript">
	$(document).ready(function(){
		$("#search").keyup(function(){
			$.ajax({
				url: 'searchbackend.php',
				type: 'post',
				data: {search: $(this).val()},
				success: function(result) {
					$("#result").html(result);
				}
			});
		});
	});
</script>

<section class="views-all-store-sec admin-store-sec ">
	<div class="container">
		<div class="transacton-outr">
			<div class="transaction-innr">
				<div class="available-outr store-name-outr">
					<div class="available-bx">
						<div class="store-name-logo">
							<img src="images/webCabinet-logo.png"/>
						</div>
						<div class="store-name-details">
							<ul>
								<li><strong>Store Name :</strong> <span>Web Cabinet India</span>  </li>
								<li><strong>Address :</strong> <span> Tarakeswar, Hooghly - 712410, WB</span></li>
								<li><strong>Email : </strong>  <span><a href="mailto: info@hih7.com"> info@webcabinet.com</a> </span></li>
               					<li><strong>Phone :  </strong><span> <a href="tel:+13089958446"> +1 308-995-8446</a></span> </li>
							</ul>
						</div>
					</div>
				</div>
				<?php 
				$fetchemplq = mysqli_query($con,"SELECT * FROM users_information WHERE ID = '$employid'");
				while ($fetchemplrow=mysqli_fetch_array($fetchemplq)) {
				// Define two dates
				$date1 = new DateTime($fetchemplrow['joining_date']);
				$date2 = new DateTime();

				// Calculate the difference
				$diff = $date1->diff($date2);
				?>
				<div class="admin_paichartsec userinfo">
					<div class="row available-bx">
						<div class="col-md-4 store-name-logo"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($fetchemplrow['UserImage']); ?>" width="160" height="160"></div>
						<div class="col-md-8 store-name-details">
							<ul>
								<li><strong>Name : </strong> <span><?php echo $fetchemplrow['FirstName']." ".$fetchemplrow['LastName']; ?></span>  </li>
								<li><strong>Designation : </strong> <span><?php echo $fetchemplrow['designation']; ?></span></li>
								<li><strong>Employee ID : </strong>  <span><?php echo "WCI-".$fetchemplrow['ID']; ?></span></li>
								<li><strong>Email : </strong>  <span><a href="mailto:<?php echo $fetchemplrow['Email']; ?>"><?php echo $fetchemplrow['Email']; ?></a> </span></li>
               					<li><strong>Phone :  </strong> <span> <a href="tel:<?php echo $fetchemplrow['MobileNumber']; ?>"><?php echo $fetchemplrow['MobileNumber']; ?></a></span> </li>
								<li><strong>Experience in WCI :  </strong> <span><?php echo $diff->y . " years, " . $diff->m . " months, " . $diff->d . " days"; ?></span> </li>
							</ul>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		
		
		<div class="total-earning-outr">
			<div class="total-innr-bx">
				<div class="total-innr-txt-outr">
					<div class="total-innr-txt">
						<h3>Total<br />Register Employ</h3>
					</div>
				</div>
				<div class="totl-ear-crcl-outr">
				  <div class="totl-ear-crcl">
						<div class="blanc-amont">
							<h1><?php echo $rowe['total_users']; ?></h1>
						</div>
					</div>
                </div>
			</div>
			
			<div class="total-innr-bx">
				<div class="total-innr-txt-outr">
					<div class="total-innr-txt">
						<h3>Entered Office <br /> Today</h3>
					</div>
				</div>
				<div class="totl-ear-crcl-outr">
				  <div class="totl-ear-crcl">
						<div class="blanc-amont">
						<?php while ($resultrow=mysqli_fetch_array($result)) { 
						$dateTime = new DateTime($resultrow["enter_office"]);
						$dateOnly = $dateTime->format("H:i");	
						?>
							<h1><?php echo $dateOnly; ?></h1>
							<?php } ?>
						</div>
					</div>
                </div>
			</div>
			
			<div class="total-innr-bx">
				<div class="total-innr-txt-outr">
					<div class="total-innr-txt">
						<h3>Leave<br /> Lefe</h3>
					</div>
				</div>

				<div class="totl-ear-crcl-outr">
				  <div class="totl-ear-crcl">
						<div class="blanc-amont">
						<?php $result=mysqli_query($con,"SELECT COUNT(*) AS total_rows FROM employ_leavemanegment_tbl WHERE employ_id = '$employid' and leave_status = 'Approved'");
						$row = $result->fetch_assoc();
						?>
							<h1><?php echo $row['total_rows']; ?></h1>
							<h2>Left: 24</h2>
						</div>
					</div>
                </div>
				
			</div>
			
		</div>
		
		
		<div class="commn-border">
			<div class="comm-hdr text-center">
				<h3>View All Employ Information</h3>
			</div>

			<div class="search-outr">
				<input type="text" id="search" placeholder="Search by Name and phone No.." class="form-control">
				<!-- <input type="submit" class="frm-sbmt" value="Search"> -->
			</div>

			<div class="all-store-manager-box str-nam-rmv">
				<h3>All User Information</h3>		
				<div class="table-overflow">
				<div class="table-width">
					<table class="table table-striped">
					    <thead>
					      <tr>
					        <th>#</th>
					        <th>Profile Img.</th>
					        <th>Name</th>
					        <th>Email</th>
					        <th>Phone No.</th>
					        <th>Date</th>
					        <th>Action</th>
					      </tr>
					    </thead>
					    <tbody id="result">
					    <?php
						$ret=mysqli_query($con,"select * from users_information");
						$cnt=1;
						$row=mysqli_num_rows($ret);
						if($row>0){
						while ($row=mysqli_fetch_array($ret)) {
						$timestamp = strtotime($row['CreationDate']);
						$getodt = date('d-m-Y', $timestamp);
						?>
							<tr>
								<td><?php echo $cnt;?></td>
								<td><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['UserImage']); ?>" width="60" height="60"></td> 
								<td><?php echo $row['FirstName'];?> <?php  echo $row['LastName'];?></td>
								<td><a href="mailto:<?php echo $row['Email'];?>"><?php echo $row['Email'];?></a></td> 
								<td><a href="tel:<?php echo $row['MobileNumber'];?>"><?php echo $row['MobileNumber'];?></a></td>                       
								<td><?php echo $getodt;?></td>
								<td>
								<?PHP 
								$getpar=mysqli_query($con,"select * from users_information where ID='".$employid."'");
								while ($getparid=mysqli_fetch_array($getpar)) {
								$logeduserid = $row['ID'];	
								if($logeduserid==$employid){ 
								?>
								<div class="action-btn">
									<a href="edit.php?editid=<?php echo htmlentities ($row['ID']);?>" class="archive-icn"><img src="images/edit.png" alt=""/></a>
									<a href="read.php?viewid=<?php echo htmlentities ($row['ID']);?>"><img src="images/view-icn.png" alt=""/></a>
									<a href="register.php?delid=<?php echo ($row['ID']);?>" title="Delete" data-toggle="tooltip" onclick="return confirm('Do you really want to Delete ?');"><img src="images/delete-icn.png" alt=""/></a>
								</div>
								<?php } else { ?>
									<div class="action-btn">
									<a href="#" disabled="disabled"><img src="images/view-icn.png" alt=""/></a>
								</div>
								<?php } }?>
								</td>
							</tr>
							<?php 
							$cnt=$cnt+1;
							} } else {?>
					     	<tr>
								<td style="text-align:center; color:red;" colspan="7">No Record Found</td>
							</tr>
							<?php } ?> 
					    </tbody>
					</table>
				</div>
				</div>
				<div class="pagination-outr">
					<div class="per-page">
						<ul>
							<li>
								<div class="box">
									<select>
										<option> 10 per Page</option>
										<option>5 per Page</option>
									</select>
								</div>
							</li>
							<li><a href="javascript:void(0);">Prev.</a></li>
							<li><a href="javascript:void(0);">Next</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
</section>

<!-- <section class="monthly_dob">
	<div class="container">
	<?php //$getqdob = mysqli_query($con,"SELECT * FROM users_information WHERE MONTH(dob) = MONTH(CURDATE())"); ?>

	<div class="slidawe-position">
		<div class="similar_pro_slider">
			<div class="swiper-wrapper">
			<div class="swiper-slide">Slide 1</div>
			<div class="swiper-slide">Slide 2</div>
			<div class="swiper-slide">Slide 3</div>
			<div class="swiper-slide">Slide 4</div>
			</div>
			
			<div class="swiper-pagination"></div>
		</div>
	</div>
	</div>
</section> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header ammodhdr">
        <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="ml_hdr">
	     <p>Hello Valued Clients,</p>
	  	</div>

		<p>We are happy to announce our new updated website!  Starting on Wednesday, February 2nd, you will see the new layout. Basic card processing functionality is the same with our Standard and Contactless types.</p>

 		<p>Your credentials and store set ups are the exact same, it’s just a new look and some added features:</p>
		<ul>
			<li>Refund Processing – refunds will now be done by you!  Simply look up the transaction and press refund, pick the Store Manager on duty who will get a OTP to allow the refund to post.</li>
			<li>Chargebacks – you will now be able to see all chargebacks and status of each chargeback as we work through each one.</li>
			<li>Security Features – when you run cards, we have added some features to protect from further chargebacks:
				<ul>
					<li>Cards can be processed two times per day, if a person tries to run their card more than that the system won’t allow for it.  We see many fraudulent charges where the person tests a small transaction to see if it works, then proceeds to charge several more times in the same day before the owner of the card notices.</li>
					<li>Anyone who completes a chargeback will be blocked from using FHL’s system anywhere in the future.</li>
					<li>A prompt for the Sales Associate to confirm if the ID matches the credit card name before proceeding to make sure a customer is not using another person’s card.</li>
				</ul>
			</li>
			<li>Clearer Reports – more detailed reports showing the details of what makes up the balance being deposited for the day.</li>
		</ul>
 	
		<p>We are excited to hear your feedback as you experience a more streamlined quicker responsive website.</p>

 		<p>If you would like any training or a walk-through of the new website for yourself or your team please select a time here:</p>

 		<p><a href="https://calendly.com/guardianbankingsolutions/training-session">https://calendly.com/guardianbankingsolutions/training-session</a></p>

 
 		<div class="ml_ftr">
 			<p>Thank you!</p>
 			<p>Gary Viramontes</p>
 		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
			var swiper = new Swiper('.similar_pro_slider', {
				slidesPerView : 3,
				loop : true,
				speed : 1000,
				spaceBetween : 25,
				autoHeight : true,
				calculateHeight : true,
				centeredSlides : false,
				freeMode : true,
				//simulateTouch : false,
				navigation : {
					nextEl : '.swiper-button-next6',
					prevEl : '.swiper-button-prev6',
				},
				breakpoints : {
					320 : {
						slidesPerView : 1,
						spaceBetween : 5,
					},
					484 : {
						slidesPerView : 1,
						spaceBetween : 15,
					},
					575 : {
						slidesPerView : 1,
						spaceBetween : 15,
					},
					600 : {
						slidesPerView : 2,
						spaceBetween : 10,
					},
					667 : {
						slidesPerView : 2,
						spaceBetween : 10,
					},
					991 : {
						slidesPerView : 2,
						spaceBetween : 15,
					},

					1024 : {
						slidesPerView : 3,
						spaceBetween : 15,
					},
					1366 : {
						slidesPerView : 3,
						spaceBetween : 15,
					},
					1440 : {
						slidesPerView : 3,
						spaceBetween : 25,
					},
				}
			});
</script>
<script src="js/swiper.js" ></script>
<?php include('footer.php'); ?>
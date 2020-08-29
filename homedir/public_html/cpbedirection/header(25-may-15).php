<?
ob_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
$logos=get_logos();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><a href="welcome.php"><img src="<?=$logos['LEFT']['path']?>" alt="<?=$logos['LEFT']['alt']?>" title="<?=$logos['LEFT']['alt']?>" border="0" /></a></td>
            <td><a href="welcome.php"><img src="images/bitranet/logo_side.gif" border="0" /></a></td>
          </tr>
        </table></td>
        <td align="right"><a href="<?=$logos['RIGHT']['url']?>" target="_blank"><img src="<?=$logos['RIGHT']['path']?>" alt="<?=$logos['RIGHT']['alt']?>" title="<?=$logos['RIGHT']['alt']?>" border="0" /></a></td>
      </tr>
    </table></td></tr>
        <tr>
          <td height="44" align="left" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td height="19" bgcolor="#D60810"><table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td valign="top" bgcolor="#D60810" style='border-bottom:2px solid #AC0000'><ul class="menu">
<? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && (in_array('cat', $_SESSION['tm_priv']) || in_array('subcat',$_SESSION['tm_priv']) || in_array('subsubcat',$_SESSION['tm_priv']))))){ ?>
                          <li class="top"><a href="#nogo" class="top_link"><span class="down">Categories</span></a>
                            <ul class="sub">
                              	<? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' &&  in_array('cat', $_SESSION['tm_priv'])))){?>
                              	<li><a href="manage_categories.php">Manage Categories</a></li>
								<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('subcat', $_SESSION['tm_priv'])))){?>
                              	<li><a href="manage_subcategories.php">Manage Sub Categories</a></li>
								<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('subsubcat', $_SESSION['tm_priv'])))){?>
                              	<li><a href="manage_subsubcategories.php">Manage Sub SubCategories</a></li>
								<? } ?>
                            </ul>
                          </li>
                          <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('floc',$_SESSION['tm_priv']) || in_array('tloc',$_SESSION['tm_priv']) || in_array('tlocm',$_SESSION['tm_priv']) || in_array('placov',$_SESSION['tm_priv']) || in_array('placovm',$_SESSION['tm_priv']) || in_array('pick',$_SESSION['tm_priv']) || in_array('pickm',$_SESSION['tm_priv'])))){?>
						  
                          <li class="top"><a href="#nogo" class="top_link"><span class="down">Tours</span></a>
                            <ul class="sub">
							<? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('floc',$_SESSION['tm_priv'])))){?>
                              <li><a href="manage_location_keywords.php">Meta Keywords</a></li>
                              <? }if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('floc',$_SESSION['tm_priv'])))){?>
                              <li><a href="manage_from_locations.php">Manage From Locations</a></li>                           
							  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('tloc',$_SESSION['tm_priv']) || in_array('tlocm',$_SESSION['tm_priv'])))){
							  ?>
                              <li><a href="manage_to_location.php" class="fly">Dest. Locations</a>
                                <ul>
                                  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('tloc',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="add_to_location.php">Add Dest. Location</a></li>
                                  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('tlocm',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_to_location.php">Manage Dest. Locations</a></li>
                                  <? } ?>
                                </ul>
                              </li>
                              <? } ?>
                              <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('placov',$_SESSION['tm_priv']) || in_array('placovm',$_SESSION['tm_priv'])))){ ?>
                              <li><a href="manage_places_covered.php" class="fly">Covered Places</a>
                                <ul>
                                  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('placov',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="add_places_covered.php">Add Places Covered</a></li>
                                  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('placovm',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_places_covered.php">Manage Places Covered</a></li>
                                  <? } ?>
                                </ul>
                              </li>
                              <? } ?>
                              <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('pick',$_SESSION['tm_priv']) || in_array('pickm',$_SESSION['tm_priv'])))){?>
                              <li><a href="manage_packages.php" class="fly">Pickup Points</a>
                                <ul>
                                  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('pick',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="add_pickup_points.php">Add Pickup Points</a></li>
                                  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('pickm',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_pickup_points.php">Manage Pickup Points</a></li>
                                  <? } ?>
                                </ul>
                              </li>
                              <? } ?>
							  
                              <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['price_list_add']) && $_SESSION['price_list_add']=='yes' && isset($_SESSION['price_list_manage']) && $_SESSION['price_list_manage']=='yes' ) ) ){?>
                              <li style="display:none"><a href="manage_pricelist.php" class="fly">Price List</a>
                                <ul>
                                  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['price_list_add']) && $_SESSION['price_list_add']=='yes' ))){ ?>
                                  <li><a href="add_pricelist.php">Add Price List</a></li>
                                  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['price_list_manage']) && $_SESSION['price_list_manage']=='yes' ))){ ?>
                                  <li><a href="manage_pricelist.php">Manage Price List</a></li>
                                  <? } ?>
                                </ul>
                              </li>
                              <? } ?>
                            </ul>
                          </li>
						<? } ?> 
						
						<? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('cms',$_SESSION['tm_priv']) || in_array('cmsm',$_SESSION['tm_priv']) || in_array('gallery',$_SESSION['tm_priv']) || in_array('gallerym',$_SESSION['tm_priv']) || in_array('updates',$_SESSION['tm_priv']) || in_array('updatesm',$_SESSION['tm_priv']) || in_array('test',$_SESSION['tm_priv']) || in_array('testm',$_SESSION['tm_priv']) || in_array('news',$_SESSION['tm_priv']) || in_array('settm',$_SESSION['tm_priv'])))){?>
						
                          <li class="top"><a href="#nogo" class="top_link"><span class="down">CMS </span></a>
                            <ul class="sub">
                              <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('cms',$_SESSION['tm_priv']) || in_array('cmsm',$_SESSION['tm_priv'])))){?>
                            <li><a href="manage_cms.php" class="fly">CMS</a>
                                <ul>
                                  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('cms',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="add_cms.php">Add CMS</a></li>
                                  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('cmsm',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_cms.php">Manage CMS</a></li>
                                  <? } ?>
                                </ul>
                              </li>
                              <? } ?>
							   <li><a href="manage_gallery.php" class="fly">Gallery</a>
                                <ul>
                                  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('gallery',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="add_gallery.php">Add Gallery</a></li>
                                  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('gallerym',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_gallery.php">Manage Gallery</a></li>
                                  <? } ?>
                                </ul>
                              </li>
							  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('updates',$_SESSION['tm_priv']) || in_array('updatesm',$_SESSION['tm_priv'])))){ ?>
							  <li><a href="manage_updates.php" class="fly">Latest Updates</a>
								<ul>
									<? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('updates',$_SESSION['tm_priv'])))){?>
									  <li><a href="add_updates.php">Add Updates</a></li>
									<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('updatesm',$_SESSION['tm_priv'])))){?>
									  <li><a href="manage_updates.php">Manage Updates</a></li>
									<? }?>
								</ul>
							  </li>
							  <? } ?>
							  
							  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('test',$_SESSION['tm_priv']) || in_array('testm',$_SESSION['tm_priv'])))){ ?>
							  <li><a href="manage_testimonials.php" class="fly">Testimonials</a>
								<ul>
								<? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('test',$_SESSION['tm_priv'])))){?>
									  <li><a href="add_testimonials.php">Add Testimonials</a></li>
									<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('testm',$_SESSION['tm_priv'])))){?>
									  <li><a href="manage_testimonials.php">Manage Testimonials</a></li>
									<? } ?>
								</ul>
							  </li>
							  <? } ?>
							   
							  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('news',$_SESSION['tm_priv'])))){?>
                              <li><a href="news_letter.php">Newsletter</a></li>
							<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('settm',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_settings.php">Settings</a></li>	
							  <? } ?> 
							  
							 <?php /*?> <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['enq_manage']) && $_SESSION['enq_manage']=='yes' ) ) ){?>
                              <li><a href="manage_enquiries.php">Enquiries</a></li>
							  <? } ?><?php */?> 
                            </ul>
                          </li>
                          <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('emp',$_SESSION['tm_priv']) || in_array('empm',$_SESSION['tm_priv']) || in_array('log',$_SESSION['tm_priv']) || in_array('footer',$_SESSION['tm_priv'])))){?>
                          <li class="top"><a href="#nogo" class="top_link"><span class="down">Office MNGT.</span></a>
                            <ul class="sub">
                              <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('emp',$_SESSION['tm_priv']) || in_array('empm',$_SESSION['tm_priv'])))){?>
                              <li><a href="manage_employee.php" class="fly">Employee Management</a>
                                <ul>
                                  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('emp',$_SESSION['tm_priv']) || in_array('emp',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="add_employee.php">Add Employee</a></li>
                                  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('empm',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_employee.php">Manage Employee</a></li>
                                  <? } ?>
                                </ul>
                              </li>		  
							  
							  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('log',$_SESSION['tm_priv'])))){?>
                              <li><a href="logdetails.php">Log Details</a></li>
							  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('footer',$_SESSION['tm_priv'])))){ ?>
                              <li><a href="footer_manage.php">Footer Mgnt</a></li>
                              <? }?>
                            </ul>
                          </li>
                          <? } ?>
						  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('vehicle',$_SESSION['tm_priv']) || in_array('pax',$_SESSION['tm_priv'])))){?>
						  <li class="top"><a href="#nogo" class="top_link"><span class="down">Settings </span></a>
						  	<ul class="sub">
							<? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('vehicle',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_vehicles.php">Manage Vehicles</a></li>
							<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('pax',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_pax.php">Manage PAX</a></li>
							<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('vehpax',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_vehicles_with_pax.php">Manage Vehicles with PAX</a></li>
							<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('travel',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_travel_charges.php">Manage Travel Charges</a></li>
							<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('room',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_room_charges.php">Manage Room Charges</a></li>  
							<? }?>
							</ul>
						  </li>
						  <? }?>
						  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin') && in_array('farcat',$_SESSION['tm_priv']) || in_array('farcatm',$_SESSION['tm_priv']) || in_array('fares',$_SESSION['tm_priv']) || in_array('faresm',$_SESSION['tm_priv']) || in_array('pack',$_SESSION['tm_priv']) || in_array('packm',$_SESSION['tm_priv']))){?>
                          <li class="top"><a href="#nogo" class="top_link"><span class="down">Fares </span></a>
                            <ul class="sub">
							
                           <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('farcat',$_SESSION['tm_priv']) || in_array('farcatm',$_SESSION['tm_priv'])))){?>
                            <li><a href="manage_fare_category.php" class="fly">Fare Category</a>
                                <ul>
                                  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('farcat',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="add_fare_category.php">Add Fare Category</a></li>
                                  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('farcatm',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_fare_category.php">Manage Fare Category</a></li>
                                  <? } ?>
                                </ul>
                              </li>
						     <? } ?>
							 
							 <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('fares',$_SESSION['tm_priv']) || in_array('faresm',$_SESSION['tm_priv']) || in_array('pack',$_SESSION['tm_priv']) || in_array('packm',$_SESSION['tm_priv'])) ) ){?>
							 <li><a href="manage_fares.php" class="fly">Fares</a>
                                <ul>
                                  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('fares',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="add_fares.php">Add Fares</a></li>
                                  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('faresm',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_fares.php">Manage Fares</a></li>
                                  <? } ?>
                                </ul>
                              </li>
							  <? } ?>
							  
							  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' &&in_array('pack',$_SESSION['tm_priv']) || in_array('packm',$_SESSION['tm_priv'])))){?>
                              <li><a href="manage_packages.php" class="fly">Packages</a>
                                <ul>
                                  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('pack',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="add_packages.php">Add Package</a></li>
                                  <? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('packm',$_SESSION['tm_priv'])))){ ?>
                                  <li><a href="manage_packages.php">Manage Packages</a></li>
                                  <? } ?>
                                </ul>
                              </li>
							  <? }?>
							  
						  </ul></li>
						  <? } ?>
						  
						  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('customers',$_SESSION['tm_priv']) || in_array('custbook',$_SESSION['tm_priv']) || in_array('custcancle',$_SESSION['tm_priv']) || in_array('enq',$_SESSION['tm_priv'])))){?>
                          <li class="top"><a href="#nogo" class="top_link"><span class="down">Customers</span></a>
                            <ul class="sub">
                           <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('customers',$_SESSION['tm_priv'])))){ ?>
			  					<li><a href="manage_customers.php">Customers</a></li>
						     <? }?>
							 <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('custbook',$_SESSION['tm_priv'])))){ ?>
								  <li><a href="customer_bookings.php">Bookings</a></li>
								<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['confirm_orders_manage']) && $_SESSION['confirm_orders_manage']=='yes' ))){ ?>
								  <!--<li><a href="confirmed_orders.php">Confirm Orders</a></li>-->
								<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('custcancle',$_SESSION['tm_priv'])))){ ?>
								  <li><a href="customer_cancellations.php">Cancellations</a></li>
								<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('enq',$_SESSION['tm_priv'])))){ ?>
			  					<li><a href="manage_enquiries.php">Enquiries</a></li>
						     <? } ?>
						  </ul></li>
						  <? } ?>
						  
						  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('agents',$_SESSION['tm_priv']) || in_array('deposits',$_SESSION['tm_priv']) || in_array('agentbook',$_SESSION['tm_priv']) || in_array('agentcancle',$_SESSION['tm_priv']) || in_array('report',$_SESSION['tm_priv'])))){ ?>
                          <li class="top"><a href="#nogo" class="top_link"><span class="">Agents</span></a>
                            <ul class="sub">
								<? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('agents',$_SESSION['tm_priv'])))){ ?>
								  <li><a href="manage_agents.php">Agents</a></li>
								<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('deposit',$_SESSION['tm_priv'])))){ ?>
								  <li><a href="manage_agent_deposits.php">Deposits</a></li>
								<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('agentbook',$_SESSION['tm_priv'])))){ ?>
								  <li><a href="agent_bookings.php">Bookings</a></li>
								<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('agentcancle',$_SESSION['tm_priv'])))){ ?>
								  <li><a href="agent_cancellations.php">Cancellations</a></li>
								<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('report',$_SESSION['tm_priv'])))){ ?>
								  <li><a href="agent_report.php">Report</a></li>  
								<? }?>  
                            </ul>
                          </li>
						  <? }?>
						  
						  <?php /*?><? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['new_orders_manage']) && $_SESSION['new_orders_manage']=='yes' && isset($_SESSION['confirm_orders_manage']) && $_SESSION['confirm_orders_manage']=='yes' && isset($_SESSION['cancel_orders_manage']) && $_SESSION['cancel_orders_manage']=='yes' ) ) ){ ?>
                          <li class="top"><a href="#nogo" class="top_link"><span class="">Orders</span></a>
                            <ul class="sub">
								<? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['new_orders_manage']) && $_SESSION['new_orders_manage']=='yes' ) ) ){ ?>
								  <li><a href="customer_bookings.php">Confirmed Orders</a></li>
								<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['confirm_orders_manage']) && $_SESSION['confirm_orders_manage']=='yes' ) ) ){ ?>
								  <!--<li><a href="confirmed_orders.php">Confirm Orders</a></li>-->
								<? } if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['cancel_orders_manage']) && $_SESSION['cancel_orders_manage']=='yes' ) ) ){ ?>
								  <li><a href="customer_cancellations.php">Cancelled Orders</a></li>
								<? }?>
                            </ul>
                          </li>
						  <? }?><?php */?>
						  
						  <? if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('busbook',$_SESSION['tm_priv'])))){ ?>
						  <li class="top"><a href="manage_bus_booking.php" class="top_link"><span class="">Bus Bookings</span></a></li>
						  <? }?>
                      </ul></td>
                      <td valign="top" bgcolor="#D60810"><table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td height="30" colspan="2" bgcolor="#D60810" style='border-bottom:2px solid #AC0000'><div class="fr mr10"><strong><a href="logout.php" class="whitelinks">Logout</a></strong></div>
                              <div class="fr mr15 whitetxt"><strong>Welcome <?=$_SESSION['tm_dispname']?>, &nbsp;&nbsp;<a href="change_password.php" class="whitelinks">Change Password</a></strong> &nbsp; &nbsp;| </div></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
  </tr>
</table>
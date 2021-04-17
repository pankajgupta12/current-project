<?
// website functions 

function create_testimonial_page_li(){
	$data = mysql_query("select * from testimonials where country_id=".mres($_SESSION['cid'])." and approved=1");
	
	while($row = mysql_fetch_assoc($data)){ 
		if($row['image']!=""){ 
			$img = $row['image'];
		}else{
			//$img = "/images/client-img-1.png";
			$img = "/blog-images/110/110/90_1.jpg";
		}
	
	echo '<li class="wow fadeInUp" data-wow-delay="0.2s">
			<div class="testimonial-working">
				<div class="testimonial-img">
					<img src="'.$img.'" alt="'.$row['name'].'">
				</div>
				<div class="testimoial-content">
					<p class="testimonial-name">'.$row['name'].'</p>
					<p class="testimonial-company">'.$row['company'].'</p>
					<p class="testimonial-rating"><span>Rating: '.$row['rating'].'</span></p>
					<p class="testimonial-para">'.html2txt($row['description']).'</p>
				</div>
			</div>
		</li>';	
	
	}
}

function create_testimonial_box($type,$country_id){

	$data = mysql_query("select * from testimonials where country_id=".mres($country_id)." and type=".mres($type)." and approved=1");
	
	while($row = mysql_fetch_assoc($data)){ 
		if($row['image']!=""){ 
			$img = $row['image'];
		}else{
			$img = "/blog-images/110/110/90_1.jpg";
		}
		
		/*echo '<li>
				<div class="testimonial-content">
					<div class="client-img">
					   <img src=" '.$img.'" alt="client">
					</div>
					<div class="quatation-para">
						<blockquote>
							'.html2txt($row['description']).'
						</blockquote>
						<span class="client-name">
							'.$row['name'].'<br />'.$row['company'].'
							
						</span>
					</div>
				</div>
			</li>';*/
			
		echo '<li>
				<div class="testimonial-content">					
					<div class="quatation-para">
						<blockquote>
							'.html2txt($row['description']).'
						</blockquote>
						<span class="client-name">
							'.$row['name'].'<br />'.$row['company'].'
							
						</span>
					</div>
				</div>
			</li>';
	}
	
}

function create_broker_directory_box($row){
	
	
	if($row['company_name']!=""){ 
		if(is_numeric($row['state'])){ 
			if($row['state']!="0"){ 
				$state_b= get_rs("state","state",$row['state']); }else{ $state=""; } 
			}else{ 
				$state_b= get_sql("state","state"," where abv='".mres($row['state'])."' and country_id=".mres($_SESSION['cid'])."");
			}
				
				//if($row['id']
				if($row['broker_url']==""){ 
					$broker_url = create_broker_url($row['company_name'],$state_b,$row['id']);
				}else{
					$broker_url = $row['broker_url'];
				}
				
				if($row['logo']!=""){
					$row['logo'] = str_replace("/images/users/","",$row['logo']);
					$row['logo'] = "/user-images/200/100/".$row['logo'];
				}
				
				$img =$row['logo'];
				
				$img = '<img src="'.$img.'">'; 
				
				/*if ($img!=""){ 
					if(file_exists($_SERVER['DOCUMENT_ROOT'].$img)){ 
						//$img = '<a href="'.$broker_url.'" ><img src="'.$img.'"></a>'; 
						$img = '<img src="'.$img.'">'; 
					}else{
						$img="";
					}
				}else{ $img=""; }*/
				
				$no_listings = mysql_query("select id from listings where user_id=".mres($row['id'])." and status=1 and advert_status=1");
				$under_offer = mysql_query("select id from listings where user_id=".mres($row['id'])." and status=1 and advert_status=3");
				$sold_listings = mysql_query("select id from listings where user_id=".mres($row['id'])." and status=1 and advert_status=2");
								
				if($row['broker_listing_url']==""){ $broker_listing_url = get_rs("users","broker_listing_url",$row['id']);  }else{ $broker_listing_url =$row['broker_listing_url']; } 
				
				$state_disp = "";
				if($row['city']!=""){ $state_disp.=$row['city'].","; }	
				$state_disp.=str_replace("_"," ",$state_b);
					
				echo '<li class="wow fadeInUp" data-wow-delay="0.2s">
                	<div class="business-img-area">
                    	'.$img.'
                    </div>
                    <div class="business-content">
                    	<a class="business-name" href="'.$broker_url.'">'.$row['company_name'].'</a>
                        <span class="business-place">'.$state_disp.'</span>                        
                        <a class="business-detail-btn" href="'.$broker_url.'">View Details</a>
                    </div>
                    <div class="business-counter-area">
                    	<p class="for-sale-circl"><span class="circle-top">For Sale</span><span class="circle-bottom">'.mysql_num_rows($no_listings).'
						</span></p>
                        <p class="undr-offer-circl"><span class="circle-top">Under Offer</span><span class="circle-bottom">'.mysql_num_rows($under_offer).'</span></p>
                        <p class="sold-circl"><span class="circle-top">Sold</span><span class="circle-bottom">'.mysql_num_rows($sold_listings).'</span></p>
                    </div>
                </li>';	
	}
}


function create_listing_box($row){ 
			$heading=show_text_heading(substr($row['heading'],0,75));
			
			if($row['url']==""){ 
				$url = create_detailpage_url($row['id']);
			}else{
				$url = $row['url'];	
			}
			$img = get_sql("listing_images","img_lrg"," where listing_id=".mres($row['id'])." order by order_id asc");
				
			if($img!=""){
				
				// http://business2sell-images.business2sellpty.netdna-cdn.com/
				// business2sell-images-business2sellpty.netdna-ssl.com
				if($_SERVER['SERVER_PORT']=="443"){ 
					$img = str_replace("/advert_images/","//business2sell-images-business2sellpty.netdna-ssl.com/",$img);
				}else{
					$img = str_replace("/advert_images/","//business2sell-images.business2sellpty.netdna-cdn.com/",$img);
				}
				//$img = str_replace("/advert_images/","",$img);
				//$img = "/listing-images/275/206/".$img;

				$img_txt = '<a href="'.$url.'"><img src="'.$img.'" alt="'.$row['category_name'].'" /></a>';
			}else{
				$img = get_sql("category_images","image"," where category_id=".mres($row['category_id'])." ");
				if($img!=""){ 
					$img_txt = '<a href="'.$url.'"><img src="'.$img.'"  alt="'.$row['category_name'].'" /></a>';					
				}
			}
			
			$state="";
			if(trim($row['city'])!=""){ if(trim($row['city'])!="0"){ $state.=$row['city'].", "; } }
			$state.= str_replace("_"," ",ucfirst($row['state_name'])); 
			
			if($row['sub_heading']!=""){ $sub_heading = show_text_only(substr($row['sub_heading'],0,120)).".."; }else{ $sub_heading=show_text_only(substr(html2txt($row['description']),0,120)).".."; }
				
			$price="";
			if($row['asking_price']==""){ $price="Undisclosed"; }else if($price=="0"){  $price="Undisclosed"; }else{ 	
				if(is_numeric($price)){ $price=$_SESSION['csettings']['currency']." ".number_format($row['asking_price'],0)."</strong>"; }else{ $price=substr($row['asking_price'],0,22); }
			}
			
			$category_str = '<li>'.$row['category_name'].'</li>';
			$cat_data = mysql_query("select cat.name,multi.category_id from category as cat inner join multi_category as multi on(cat.id=multi.category_id and multi.listing_id=".mres($row['id']).")");
			while($cat_row = mysql_fetch_assoc($cat_data)){ 
				$category_str.= '<li>'.$cat_row['name'].'</li>'; 
			} 
			
			$logo_str='';
			 $broker_license_status="";
			 if($row['type']=="2"){
				 $bdata = mysql_query("select * from broker_license WHERE broker_id='".mres($row['user_id'])."' and status=1");
				 if(mysql_num_rows($bdata)>0){ 
					$broker_license_status=1;
				 }else{ 
					$broker_license_status=0;
				 }
			 }else{
					$bdata = mysql_query("select * from franchise_license WHERE franchise_id='".mres($row['user_id'])."' and status=1");
				 if(mysql_num_rows($bdata)>0){ 
					$broker_license_status=1;
				 }else{ 
					$broker_license_status=0;
				 }
			
			 }
			 if($row['logo']!=""){
					$row['logo'] = str_replace("/images/users/","",$row['logo']);
					$row['logo'] = "/user-images/160/60/".$row['logo'];
				}
			if($broker_license_status=="1"){
				if($row['type']==2){ 
					$broker_license_type = get_sql("broker_license","license_type", " where broker_id=".mres($row['user_id'])."");
					$broker_directory = get_sql("license_type","broker_directory"," where id=".mres($broker_license_type)."");				
					if($broker_directory=="1"){ 
						$broker_url = get_rs("users","broker_url",$row['user_id']);
						if($broker_url==""){ 
							$user_qry = mysql_fetch_assoc(mysql_query("select type,logo,company_name,state from users WHERE id='".mysql_real_escape_string($row['user_id'])."'"));
							$broker_url = create_broker_url($user_qry['company_name'],$user_qry['state'],$row['user_id']);
						}
						if($row['logo']!=""){ $logo_str = '<a href="'.$broker_url.'"><img src="'.$row['logo'].'" alt="'.$user_qry['company_name'].'" /></a>'.$eol; };
					}else{
						$user_qry = mysql_fetch_assoc(mysql_query("select type,logo,company_name,state from users WHERE id='".mysql_real_escape_string($row['user_id'])."'"));
						if($row['logo']!=""){ $logo_str='<img src="'.$row['logo'].'" alt="'.$user_qry['company_name'].'" />'.$eol; };	
					}
				}else if ($row['type']=="3"){											
					$broker_url = get_rs("users","broker_url",$row['user_id']);
					if($broker_url==""){ 
						$user_qry = mysql_fetch_assoc(mysql_query("select type,logo,company_name,state from users WHERE id='".mysql_real_escape_string($row['user_id'])."'"));
						$broker_url = create_franchise_url($user_qry['company_name'],$user_qry['state'],$row['user_id']);
					}
					if($row['logo']!=""){ $logo_str='<a href="'.$broker_url.'"><img src="'.$row['logo'].'" alt="'.$user_qry['company_name'].'" /></a>'.$eol; };	
				}
			}
			$save_str = '';
			if($_SESSION['buyer_id']!=""){ 
				$id=get_sql("buyers_hotlist","id"," where listing_id=".mres($row['id'])." and buyer_id=".mres($_SESSION['buyer_id'])."");
				if($id==""){
					$save_str ="<div id=\"div_hotlist_".$row['id']."\"><a class=\"save-btn\" href=\"javascript:send_data('".$row['id']."',1,'div_hotlist_".$row['id']."');\"></a></div>".$eol;
				}else{
					$save_str ="<div id=\"div_hotlist_".$row['id']."\" ><a class=\"saved-btn\" href=\"javascript:send_data('".$row['id']."',2,'div_hotlist_".$row['id']."');\"></a></div>".$eol;
				}
			}else{
				$save_str ="<div id=\"div_hotlist_".$row['id']."\"><a class=\"save-btn\"href=\"javascript:send_data('".$row['id']."',1,'div_hotlist_".$row['id']."');\"></a></div>".$eol;									
			}
echo '<li class="wow fadeInUp" data-wow-delay="0.2s">
<div class="result-img">'.$img_txt.'</div>
<div class="result-content-area">
<a class="result-title" href="'.$url.'">'.$heading.'</a>
<span class="gold-cost-text">'.$state.'</span>
<span class="price-text">Price: '.$price.'</span>
<ul class="categories-area">
'.$category_str.'
</ul>
<p class="result-para">'.$sub_heading.'</p>
</div>
<div class="result-logo">
<div class="user-logo-img">
'.$logo_str.'
</div>
<span class="result-content-btn">
'.$save_str.'
<a class="detail-btn" href="'.$url.'"></a>
</span>
</div>
</li>';						
}

function create_feature_listing_box($row){ 
	$heading=show_text_only(substr($row['heading'],0,65));
			
			if($row['url']==""){ 
				$url = create_detailpage_url($row['id']);
			}else{
				$url = $row['url'];	
			}
			$img = get_sql("listing_images","image"," where listing_id=".mres($row['id'])." order by order_id asc");
				
			if($img!=""){
				$img = str_replace("/advert_images/","",$img);
				$img = "/listing-images/275/206/".$img;
				$img_txt = '<a href="'.$url.'"><img src="'.$img.'" alt="'.$row['category_name'].'" /></a>';
			}else{
				$img = get_sql("category_images","image"," where category_id=".mres($row['category_id'])." ");
				if($img!=""){ 
					$img_txt = '<a href="'.$url.'"><img src="'.$img.'"  alt="'.$row['category_name'].'" /></a>';
				}
			}
			
			$state="";
			if(trim($row['city'])!=""){ if(trim($row['city'])!="0"){ $state.=$row['city'].", "; } }
			$state.= str_replace("_"," ",ucfirst($row['state_name'])); 
			
			if($row['sub_heading']!=""){ $sub_heading = show_text_only(substr($row['sub_heading'],0,200)).".."; }else{ $sub_heading=show_text_only(substr(html2txt($row['description']),0,200)).".."; }
				
			$price="";
			if($row['asking_price']==""){ $price="Undisclosed"; }else if($price=="0"){  $price="Undisclosed"; }else{ 	
				if(is_numeric($price)){ $price=$_SESSION['csettings']['currency']." ".number_format($row['asking_price'],0)."</strong>"; }else{ $price=$row['asking_price']; }
			}
			
			$category_str = '<li>'.$row['category_name'].'</li>';
			$cat_data = mysql_query("select cat.name,multi.category_id from category as cat inner join multi_category as multi on(cat.id=multi.category_id and multi.listing_id=".mres($row['id']).")");
			while($cat_row = mysql_fetch_assoc($cat_data)){ 
				$category_str.= '<li>'.$cat_row['name'].'</li>'; 
			} 
			
			$logo_str='';
			 $broker_license_status="";
			 if($row['type']=="2"){
				 $bdata = mysql_query("select * from broker_license WHERE broker_id='".mres($row['user_id'])."' and status=1");
				 if(mysql_num_rows($bdata)>0){ 
					$broker_license_status=1;
				 }else{ 
					$broker_license_status=0;
				 }
			 }else{
					$bdata = mysql_query("select * from franchise_license WHERE franchise_id='".mres($row['user_id'])."' and status=1");
				 if(mysql_num_rows($bdata)>0){ 
					$broker_license_status=1;
				 }else{ 
					$broker_license_status=0;
				 }
			
			 }
			if($row['logo']!=""){
				$row['logo'] = str_replace("/images/users/","",$row['logo']);
				$row['logo'] = "/user-images/160/60/".$row['logo'];
					
				if($broker_license_status=="1"){
					if($row['type']==2){ 
						$broker_license_type = get_sql("broker_license","license_type", " where broker_id=".mres($row['user_id'])."");
						$broker_directory = get_sql("license_type","broker_directory"," where id=".mres($broker_license_type)."");				
						if($broker_directory=="1"){ 
							$broker_url = get_rs("users","broker_url",$row['user_id']);
							if($broker_url==""){ 
								$user_qry = mysql_fetch_assoc(mysql_query("select type,logo,company_name,state from users WHERE id='".mysql_real_escape_string($row['user_id'])."'"));
								$broker_url = create_broker_url($user_qry['company_name'],$user_qry['state'],$row['user_id']);
							}
							if($row['logo']!=""){ $logo_str = '<a href="'.$broker_url.'"><img src="'.$row['logo'].'" alt="'.$user_qry['company_name'].'" /></a>'.$eol; };
						}else{
							$user_qry = mysql_fetch_assoc(mysql_query("select type,logo,company_name,state from users WHERE id='".mysql_real_escape_string($row['user_id'])."'"));
							if($row['logo']!=""){ $logo_str='<img src="'.$row['logo'].'" alt="'.$user_qry['company_name'].'" />'.$eol; };	
						}
					}else if ($row['type']=="3"){											
						$broker_url = get_rs("users","broker_url",$row['user_id']);
						if($broker_url==""){ 
							$user_qry = mysql_fetch_assoc(mysql_query("select type,logo,company_name,state from users WHERE id='".mysql_real_escape_string($row['user_id'])."'"));
							$broker_url = create_franchise_url($user_qry['company_name'],$user_qry['state'],$row['user_id']);
						}
						if($row['logo']!=""){ $logo_str='<a href="'.$broker_url.'"><img src="'.$row['logo'].'" alt="'.$user_qry['company_name'].'" /></a>'.$eol; };	
					}
				}
			}
			$save_str = '';
			if($_SESSION['buyer_id']!=""){ 
				$id=get_sql("buyers_hotlist","id"," where listing_id=".mres($row['id'])." and buyer_id=".mres($_SESSION['buyer_id'])."");
				if($id==""){
					$save_str ="<div id=\"div_hotlist_".$row['id']."\"><a class=\"save-btn\" href=\"javascript:send_data_noloading('".$row['id']."',1,'div_hotlist_".$row['id']."');\"></a></div>".$eol;
				}else{
					$save_str ="<div id=\"div_hotlist_".$row['id']."\" ><a class=\"saved-btn\" href=\"javascript:send_data_noloading('".$row['id']."',2,'div_hotlist_".$row['id']."');\"></a></div>".$eol;
				}
			}else{
				$save_str ="<div id=\"div_hotlist_".$row['id']."\"><a class=\"save-btn\"href=\"javascript:send_data_noloading('".$row['id']."',1,'div_hotlist_".$row['id']."');\"></a></div>".$eol;									
			}
echo '<li>
<div class="feature-business-content">
<div class="result-img">'.$img_txt.'</div>
<div class="result-content-area">
<a class="result-title" href="'.$url.'">'.$heading.'</a>
<span class="gold-cost-text">'.$state.'</span>
<span class="price-text">Price: '.$price.'</span>
<ul class="categories-area">
'.$category_str.'
</ul>
<p class="result-para">'.$sub_heading.'</p>
</div>
<div class="result-logo">
<div class="user-logo-img">
'.$logo_str.'
</div>
<span class="result-content-btn">
'.$save_str.'						   
<a class="detail-btn" href="'.$url.'"></a>
</span>
</div>
</div>
</li>';
}

function home_page_category(){
	$arg="select category_id,count(*) as count from view_listings_new where country_id=".mres($_SESSION['cid'])." and status=1 and advert_status!=2 and category_id!='' and category_id!='0' group by category_id order by count(*) desc LIMIT 0 , 16";
	$data=mysql_query($arg);
	//echo mysql_num_rows($data);
	 if(mysql_num_rows($data)<"16"){
		  $arg="select * from category order by rand() LIMIT 0 , 16";
		 // echo $arg;
		  $data=mysql_query($arg);
		while ($row = mysql_fetch_assoc($data)) {
				$skey="";
				$cname=$row['name'];
				$skey=$row['seo_keyword'];
				$cnameedit = strtolower(str_replace(" ","-",$cname));
				if($skey!=""){ 
					echo '<li><a href="/businesses/cat-'.$cnameedit.'/">'.ucfirst($skey).' </a></li>'.$eol;
				}else{
					echo '<li><a href="/businesses/cat-'.$cnameedit.'/">'.$cname.' </a></li>'.$eol;
				}
		}
	 }else{
		 while ($row = mysql_fetch_assoc($data)) {
			$skey="";
			$cname=get_rs("category","name",$row['category_id']);
			//$skey=get_rs("category","seo_keyword",$row['category_id']);
			$cnameedit = strtolower(str_replace(" ","-",$cname));
			/*if($skey!=""){ 
				echo '<li><a href="/businesses/cat-'.$cnameedit.'/">'.ucfirst($skey).' ('.$row['count'].') </a></li>'.$eol;
			}else{*/
				echo '<li><a href="/businesses/cat-'.$cnameedit.'/">'.$cname.' ('.$row['count'].')</a></li>'.$eol;
			//}
		}
	 }
}


function home_page_majorcities(){
	$arg="select state,city,count(*) as count from view_listings_new where country_id=".mres($_SESSION['cid'])." and status=1 and advert_status!=2 and city!='' and city!='0' group by city order by count(*) desc LIMIT 0 , 16";
	$data=mysql_query($arg);
	if(mysql_num_rows($data)<"16"){
		   $arg="select * from city where country_id=".mres($_SESSION['cid'])." order by rand() LIMIT 0 , 16";
		  $data=mysql_query($arg);
	 }
	while ($r = mysql_fetch_assoc($data)) {
		if(strtolower($r['city'])=="gold coast"){ 
			echo '<li><a href="'.$_SESSION['csettings']['home_url'].'/businesses/qld/'.str_replace(" ","-",strtolower($r['city'])).'/" >'.ucwords(strtolower($r['city'])).'</a></li>';
		}else{
				echo '<li><a href="'.$_SESSION['csettings']['home_url'].'/businesses/'.strtolower($r['state']).'/'.str_replace(" ","-",strtolower($r['city'])).'/" >'.ucwords(strtolower($r['city'])).'</a></li>';
		}
	}
}
function create_blog_first_box($row){
	
	// <ul class="top-blog-area">
	if($row['new_url']==""){ 
		$row['new_url']=create_blog_url($row['id']);
	}	
	
	if($row['image']!=""){ $img = $row['image']; 	
		
		if($_SERVER['SERVER_PORT']=="443"){ $img = str_replace("http://","https://",$img); }
		
		if($_SERVER['device']=="iphone"){ 
			$img = str_replace("/600/300","/306/171",$img);		
		}else{
			$img = str_replace("/600/300","/639/359",$img);		
		}
	}else{ 
		$img = "/images/blog-profile-img.png"; 		
	}
	
	//echome("author".$row['author_id']);
	
	if($row['author_id']!="0"){
		$author = get_rs_value("articles_author","name",$row['author_id']);
		$auth_img = get_rs_value("articles_author","image",$row['author_id']);
		$auth_img = str_replace("/images/articles_author","/author-images/65/65",$auth_img);	
		$auth_url = get_rs_value("articles_author","url",$row['author_id']);
		//echome("url".$auth_url);
		if($auth_url==""){ 
			$new_auth_url = strtolower("/blogs/author/".show_text_only_url($author));
			$bool = mysql_query("update articles_author set url='".$new_auth_url."' where id=".$row['author_id']);
			$auth_url = strtolower($new_auth_url);
		}
	}else{
		$author= $row['author'];
		if($row['author_image']!=""){ 
			$auth_img = $row['author_image'];
			$auth_img = str_replace("http://www.business2sell.com.au","",$auth_img);
			
			$auth_img = str_replace("/600/300","/65/65",$auth_img);	
		}else{ 
			//$auth_img = "/blog-images/65/65/90_1.jpg";
			$auth_img = "/images/blog-profile-img.png"; 		
		}
	}
	
	/*if($row['author_image']!=""){ $auth_img = $row['author_image'];
		if($_SERVER['SERVER_PORT']=="443"){ $auth_img = str_replace("http://","https://",$auth_img); }
		$auth_img = str_replace("/600/300","/65/65",$auth_img);	
	}else{ $auth_img = "/images/blog-profile-img.png"; 		
	}*/
	
	echo '<li class="wow fadeInUp" data-wow-delay="0.2s">
			<div class="top-blog-img">
				<img src="'.$img.'" alt="'.show_text_only($row['heading']).'">
				<div class="top-blog-content">
					<span class="top-blog-profile-img">
					<img src="'.$auth_img.'" alt="'.stripslashes($row['author']).' Image">
					</span>
					<span class="top-blog-profile-name">';
					if($auth_url!=""){ 
						echo '<a href="'.$auth_url.'">'.stripslashes($row['author'])."</a>"; 
					}else{
						echo stripslashes($row['author']); 
					}					
					echo '<br>'.date("l jS \of F Y ",strtotime($row['date'])).'</span>
					<a class="top-blog-title" href="'.$row['new_url'].'">'.show_text_only($row['heading']).'</a>
				</div>
			</div>
			
			<a class="blog-read-more-btn" href="'.$row['new_url'].'">Read More</a>
		</li>';
		
		
}

function create_blog_second_box($row){
	
	// <ul class="top-blog-area">
	if($row['new_url']==""){ 
		$row['new_url']=create_blog_url($row['id']);
	}
	
	$desc = str_replace("&nbsp;"," ",$desc);
	$desc = str_replace("&rsquo;","'",$desc);
	
	$next_space =strpos($row['description']," ",150);
	$desc = html2txt($row['description']);
	$desc = substr($desc,0,$next_space);
	
	if($row['image']!=""){ 
		$img = $row['image'];
		if($_SERVER['SERVER_PORT']=="443"){ $img = str_replace("http://","https://",$img); }
		$img = str_replace("/600/300","/246/232",$img);		
	}else{ $img = "/images/blog-profile-img.png"; 		
	}
	
	if($row['author_id']!="0"){
		$author = get_rs_value("articles_author","name",$row['author_id']);
		$auth_img = get_rs_value("articles_author","image",$row['author_id']);
		$auth_img = str_replace("/images/articles_author","/author-images/65/65",$auth_img);	
		$auth_url = get_rs_value("articles_author","url",$row['author_id']);
		//echome("url".$auth_url);
		if($auth_url==""){ 
			$new_auth_url = strtolower("/blogs/author/".show_text_only_url($author));
			$bool = mysql_query("update articles_author set url='".$new_auth_url."' where id=".$row['author_id']);
			$auth_url = strtolower($new_auth_url);
		}
	}else{
		$author= $row['author'];
		if($row['author_image']!=""){ 
			$auth_img = $row['author_image'];
			$auth_img = str_replace("http://www.business2sell.com.au","",$auth_img);
			
			$auth_img = str_replace("/600/300","/65/65",$auth_img);	
		}else{ 
			//$auth_img = "/blog-images/65/65/90_1.jpg";
			$auth_img = "/images/blog-profile-img.png"; 		
		}
	}
	
	/*if($row['author_image']!=""){ 
		$auth_img = $row['author_image'];
		if($_SERVER['SERVER_PORT']=="443"){ $auth_img = str_replace("http://","https://",$auth_img); }
		$auth_img = str_replace("/600/300","/65/65",$auth_img);	
	}else{ 
		//$auth_img = "/images/blog-profile-img.png"; 		
		$auth_img = "/blog-images/600/300/90_1.jpg";
		$auth_img = str_replace("/600/300","/65/65",$auth_img);	
		
	}*/
	
	if($row['category_id']!=""){ 
		$category = strtolower(get_rs("es2sell_blog_category","name",$row['category_id']));
	}else{ 
		$category="general";
	}
	
	echo '<li class="wow fadeInUp" data-wow-delay="0.2s">
			<div class="bottom-blog-img">
				<img src="'.$img.'" alt="'.show_text_only($row['heading']).'">
				<div class="hover_content">
					<a class="portfo-hover-icon" href="'.$row['new_url'].'"> </a>
				</div>
			</div>
			<div class="bottom-blog-content-area">
				<a class="bottom-blog-head" href="'.$row['new_url'].'">'.show_text_only($row['heading']).'</a>
				<ul class="top-blog-date-area">
					<li>'.date("l jS \of F Y ",strtotime($row['date'])).'</li>
					<li><a href="/blogs/'.$category.'/">'.ucwords($category).'</a></li>
				</ul>				
				<p class="bottom-blog-para">'.$desc.'</p>
				<div class="bottom-blog-profile">
					<span class="top-blog-profile-img">
						<img src="'.$auth_img.'" alt="'.stripslashes($row['author']).' Image">
					</span>
					<span class="bottom-blog-profile-name">';
					if($auth_url!=""){ 
						echo '<a href="'.$auth_url.'">'.stripslashes($row['author'])."</a>"; 
					}else{
						echo stripslashes($row['author']); 
					}	
					echo'</span>
				</div>
			</div>
		</li>';
		
}

// used in blog page in side bar 
function create_blog_side_box($row){
	if($row['new_url']==""){ 
		$row['new_url']=create_blog_url($row['id']);
	}
	
	if($row['author_id']!="0"){
		$author = get_rs_value("articles_author","name",$row['author_id']);
		$auth_url = get_rs_value("articles_author","url",$row['author_id']);
		if($auth_url==""){ 
			$new_auth_url = strtolower("/blogs/author/".show_text_only_url($author));
			$bool = mysql_query("update articles_author set url='".$new_auth_url."' where id=".$row['author_id']);
			$auth_url = strtolower($new_auth_url);
		}
	}else{
		$author= $row['author'];
	}
	
	
	$desc = str_replace("&nbsp;"," ",$desc);
	$desc = str_replace("&rsquo;","'",$desc);
	
	$next_space =strpos($row['description']," ",300);
	$desc = html2txt($row['description']);
	$desc = substr($desc,0,$next_space);
	
	
	
	if($row['image']!=""){ 
		$img = $row['image'];
		if($_SERVER['SERVER_PORT']=="443"){ $img = str_replace("http://","https://",$img); }
		$img = str_replace("/600/300","/284/200",$img);		
	}else{ $img = "/images/faq-post-img-2.png"; 		
	}

	echo '<li class="wow fadeInUp" data-wow-delay="0.2s">
		<div class="faq-post-list-img">
			<img src="'.$img.'" alt="By '.stripslashes($row['author']).'">
		</div>
		<p class="faq-post-list-para"><a href="'.$row['new_url'].'" class="from-blog-head">'.show_text_only($row['heading']).'</a></p>
		<p class="faq-post-list-author">By ';
		
		if($auth_url!=""){ 
			echo '<a href="'.$auth_url.'">'.stripslashes($author)."</a>"; 
		}else{
			echo stripslashes($row['author']); 
		}	
		echo ', '.date("l jS \of F Y ",strtotime($row['date'])).'</p>
		<a class="faq-post-list-read-more" href="'.$row['new_url'].'">Read More</a>
	</li>';
		  
		  
}


function create_blog_box($row){
	if($row['new_url']==""){ 
		$row['new_url']=create_blog_url($row['id']);
	}
	
	$desc = str_replace("&nbsp;"," ",$desc);
	$desc = str_replace("&rsquo;","'",$desc);
	
	$next_space =strpos($row['description']," ",300);
	$desc = html2txt($row['description']);
	$desc = substr($desc,0,$next_space);
	
	if($row['image']!=""){ 
		$img = $row['image'];
		if($_SERVER['SERVER_PORT']=="443"){  $img = str_replace("http://","https://",$img); }
		//$img = str_replace("/600/300","/454/248",$img);		
		if($_SERVER['device']=="iphone"){ 
			$img = str_replace("/600/300","/308/171",$img);		
		}else{
			$img = str_replace("/600/300","/454/248",$img);		
		}
	}else{ $img = "/images/blog-profile-img.png"; 		
	}
	
echo '<li>
<div class="from-blog-working wow fadeInLeft" data-wow-delay="0.2s">
<div class="from-blog-top-area">
<div class="from-blog-img"> <img src="'.$img.'"> </div>
<a href="'.$row['new_url'].'" class="from-blog-head">'.show_text_only($row['heading']).'</a>
<ul class="from-blog-date-area">
<li>'.date("l jS \of F Y ",strtotime($row['date'])).'</li>
<li> By '.stripslashes($row['author']).'</li>
</ul>
<p class="from-blog-para">'. ($desc).'</p>
<a class="read-more-2 read-more-3" href="'.$row['new_url'].'">Read More</a> </div>                  
</div>
</li>';	
		 
		  
		  
}

function get_calc_page($page){
	$numbers = "123456789";
	$tags[0] = "+";
	$tags[1] = "-";
	//$tags[2] = "x";
	
	//$alpha_arr = str_split($numbers);
	$num1 = createCode_new();
	$num2 = createCode_new();
	$i = rand(0,1);
	
	if($num2>$num1){
		$num3 = $num2;
		$num2 = $num1;
		$num1 = $num3;
	}
	
	if($i==0){
		$answer = $num1+$num2;	
	}else if($i==1){
		$answer = $num1-$num2;
	}else if($i==2){
		$answer = $num1*$num2;
	}
	
	$_SESSION['captcha_phrase']  = $answer;
	if($page=="enq"){ 
		echo '<span>'.$num1.' '.$tags[$i].' '.$num2.'</span></p>
		<p>Code is answer of the small calculation:</p>';
	}else if ($page=="register"){ 
		echo 'Security Code : '.$num1.' '.$tags[$i].' '.$num2.'<br />Code is answer of the small calculation';
	}else if ($page=="agent_profile"){ 
		echo 'Security Code : '.$num1.' '.$tags[$i].' '.$num2.' = ? ';
	}else if ($page=="forgot_password"){ 
		echo 'Security Code : '.$num1.' '.$tags[$i].' '.$num2.' = ? ';
	}
	//echo "<div id=\"div_".rand()."\" class=\"param\">Security Code : <span class=\"text11_red\">".$num1." ".$tags[$i]." ".$num2." </span></div> ";
	//echo '<div class="text11">Code is answer of the small calculation: </div>';

}

function view_saved(){
	if($_SESSION['buyer_id']!=""){ 
	$arg="select * from view_buyers_hotlist_new where buyer_id=".mres($_SESSION['buyer_id'])." order by hotlist_id desc ";
	$data = mysql_query($arg); 

	echo '<div class="view-saved-tag">
		<span id="view_saved_num" class="star-black">'.mysql_num_rows($data).'</span> 
		<span id="view_saved_txt" class="saved-listing-txt"> Saved Listings </span>
	</div>
	<div class="view-saved-area">';
	
	if(mysql_num_rows($data)>0){ 
	
		echo '<ul class="save-list">';
		while($row=mysql_fetch_assoc($data)){ 
			
			$heading=show_text_only(substr($row['heading'],0,45));
				
			if($row['url']==""){ 
				$url = create_detailpage_url($row['id']);
			}else{
				$url = $row['url'];	
			}
			$img = get_sql("listing_images","image"," where listing_id=".mres($row['id'])." order by order_id asc");
			if($img!=""){
				$img = str_replace("/advert_images/","",$img);
				$img = "/listing-images/133/75/".$img;
				$img_txt = '<a href="'.$url.'"><img src="'.$img.'" alt="'.$row['category_name'].'" /></a>';
			}else{
				$img = get_sql("category_images","image"," where category_id=".mres($row['category_id'])." ");
				if($img!=""){ 
					$img_txt = '<a href="'.$url.'"><img src="'.$img.'"  alt="'.$row['category_name'].'" /></a>';
				}
			}
			
			echo '<li>
				<div class="save-img">
					<a class="cros-icon" href="javascript:send_data(\''.$row['id'].'\',2,\'div_hotlist_'.$row['id'].'\');"></a>
					'.$img_txt.'
					<span class="img-over-txt">'.$heading.'</span>
					</a>
				</div>
			</li>';
			 } 
		echo '</ul>';
	 }
	echo '</div>';
	}
}

function create_faqs($category_id,$limit){
	if($category_id!=""){ 
		$arg = "select * from faqs where country_id=".mres($_SESSION['cid'])." and category_id=".mres($category_id)." limit 0,".$limit;
	}else{
		$arg = "select * from faqs limit 0,".mres($limit);		
	}
	//echo $arg;
	$data = mysql_query($arg);
	
	if(mysql_num_rows($data)>0){ 
	
	echo '<dl id="faqs">';
	  while ($r=mysql_fetch_assoc($data)){ 
			echo '<dt>'.$r['question'].'</dt>
			<dd>'.stripslashes(str_replace("http://","https://",$r['answer'])).'</dd>';	  
	  }
	  
	echo '</dl>';

	}else{
		if($_SESSION['cid']=="1"){ 
			echo '<dl id="faqs">
				  <dt>We are working on the FAQ\'s in this section, Please Contact us for more information </dt>
				  <dd>You can contact us by email or by filling the contact us form. <br>
						You can also call us at 1300 556 121 during office hours<br>
						Our Office Hours are Monday to Friday, 9.00 PM to 5.00 PM AEST Monday to Friday. </dd>
				 </dl>';
		}else{ 
		
			echo '<dl id="faqs">
				  <dt>We are working on the FAQ\'s in this section, Please Contact us for more information </dt>
				  <dd>You can contact us by email or by filling the contact us form. <br>
						Or Email us at '.$_SESSION['csettings']['email'].' </dd>
				 </dl>';
		} 
		
	}	
}

function broker_profile_agents($details){
	if($details['agent_image']!=''){
		$agent_img='<img src="'.$details['agent_image'].'" width="120">';
	}else{
		$agent_img='<img src=/images/no_image_person.jpg width=120 height=135>';
	}
	$agentname=str_replace(" ","_",$details['name']);
	$agent_url = create_agent_url($details['id']);
	$agent_listing_url = get_rs("agents","listing_url",$details['id']);
	
	echo '<li>
		<span class="agent-profile-img">'.$agent_img.'</span>
		<span class="agent-name"><a href="'.$agent_url.'">'.$details['name'].'</a></span>
		<span class="agent-phone">Phone : '.$details['phone'].'</span>';
		if($details['mobile']!=""){ 
			echo '<span class="agent-phone">Mobile : '.$details['mobile'].'</span>';
		}
		//echo '<a class="view-listing-btn" href="'.$agent_listing_url.'">View Listing</a>';
		//echo '<a class="view-detail-btn" href="'.$agent_url.'">View Details</a>';
	echo '</li>';
}

function create_agent_url($agent_id){
	  $url = get_sql("agents","agent_url"," where id='".mres($agent_id)."'");
  if($url!=""){ 
	return $url;  
  }else{ 
	  	 $broker_id = get_rs_value("agents","broker_id",$agent_id);
		 $broker_url = get_rs_value("users","broker_listing_url",$broker_id);
		 $agent_name = get_rs_value("agents","name",$agent_id);

		 if($agent_name==""){ 
		 	if($broker_name!=""){ 
			 	$agent_name = $broker_name."-agent".$agent_id;
			}else{
				$agent_name = "agent".$agent_id;
			}
		 }
		 
		 $agent_name = show_text_only($agent_name);
		 $agent_name = strtolower(str_replace("-","",$agent_name));
		 $agent_name = strtolower(str_replace(" ","-",$agent_name));

		 
	     $url=$broker_url.$agent_name.".php";
		 $url = strtolower(str_replace("broker-listings","broker-details",$url));
		 $listing_url=$broker_url.$agent_name."/";
		 
		 $uarg="update agents set agent_url='".$url."',listing_url='".$listing_url."' where id=".$agent_id."";
		 
		 
		 $bool = mysql_query($uarg);
		 return $url;
		  } // end if 
}

function franchise_directory_box($row){
	if($row['broker_url']==""){ 
		$broker_url = create_franchise_url($row['company_name'],$row['state'],$row['franchise_id']);
	}else{
		$broker_url =$row['broker_url'];
	}
	$img="";
	
	if($row['user_logo']!=""){ 
		$img=$row['user_logo'];
	}else if($row['logo']!=""){ 
		$img=$row['logo'];
	}


	if($img!=""){
		$img = str_replace("/images/users/","",$img);
		$img = "/user-images/200/100/".$img;
	}
	//$franchise_listings = mysql_query("select * from franchise_listings where franchise_id=".mres($row['franchise_id'])."");
	
	$img = '<a href="'.$broker_url.'" ><img src="'.$img.'"></a>'; 
	
	$short_desc = html2txt($row['description']);
	$short_desc = substr($short_desc,0,150);	
	
	echo ' <li class="wow fadeInUp" data-wow-offset="100">
			<span class="franchise-img">'.$img.'</span>
			<div class="frnchise-content-area">
				<p class="franchise-head"><a href="'.$broker_url.'" >'.stripslashes($row['heading']).'</a></p>';
	if($row['region']!=""){ echo '<p class="franchise-txt"><span class="franchise-txt-head">Region :</span> '.$row['region'].'</p>'; }
	if($row['category_id']!=""){ echo '<p class="franchise-txt"><span class="franchise-txt-head">Category :</span> '.$row['category_name'].'</p>'; }
	if($row['investment_amt']!=""){ echo'<p class="franchise-txt"><span class="franchise-txt-head">Investment Amount :</span> '.$row['investment_amt'].'</p>'; }
	
	echo '<p class="franchise-txt"><span class="franchise-txt-head">Franchise Id :</span> '.$row['franchise_id'].'</p>
				<p class="franchise-inner-contnt">
					<span class="franchise-para">'.$short_desc.'...
					</span>
					<span class="franchise-btn-area">
						<a class="franchise-detail-btn" href="'.$broker_url.'">View Details</a>';
						
						/*if(mysql_num_rows($franchise_listings)>0){ 
							$broker_listing_url =$row['broker_listing_url'];  
							echo'<a class="franchise-listing-btn" href="'.$broker_listing_url.'">View listing</a>';
						}*/
					echo'</span>
				</p>
			</div>
		</li>';
}

function services_directory_box($row){
	
	
	if($row['logo']!=""){ 
		 $img =$row['logo'];
	}else{
		$img = 	get_sql("user_type_details","logo"," where user_id=".mres($row['id'])."");
	}
	$img = '<img src="'.$img.'">';

	 
	 $url = create_business_service_url($row['id']);

	 $user_types_data = mysql_query("select * from view_user_type_details where user_id=".mres($row['id'])."");
	 $utflag = true;
	 
	$short_desc="";
	$url_tag = "";
		while($ut = mysql_fetch_assoc($user_types_data)){
			if($utflag){ $utflag=false; 
			$ut_txt = html2txt($ut['description']);
			$short_desc=str_replace("	","",substr($ut_txt,0,255))." ... <br><br><br>";
			}
			
			if($ut['url']==""){ 
				$ut['url'] = create_user_type_details_url($ut['user_id'],$ut['type_id']);
			}
			$url_tag.='<a href="'.$ut['url'].'" class="franchise-listing-btn">'.$ut['type_name'].'</a>&nbsp';
		}

	
	
	echo ' <li class="wow fadeInUp" data-wow-offset="100">
			<span class="franchise-img">'.$img.'</span>
			<div class="frnchise-content-area">
				<p class="franchise-head"><a href="'.$url.'" >'.$row['company_name'].'</a></p>';
	
		echo '<p class="franchise-inner-contnt">
					<span class="franchise-para">'.$short_desc.'...
					</span>';
					//<span class="franchise-btn-area">'.$url_tag.'</span>					
				echo '</p>
			</div>
		</li>';
}

//pusher to send
function sendNotification( $datas = null )
{
	
	if( !empty($datas) )
	{
			
		
		
	}
	
	$options = array(
		'cluster' => 'us2',
		'encrypted' => true
	  );
	  $pusher = new Pusher\Pusher(
		'724a1d2b3deb2c640bdc',
		'a5e4097dae77ed110cf4',
		'440657',
		$options
	  );
 
	  $data['message'] = $datas;
	  $pusher->trigger('my-channel', 'my-event', $data);
	
	
	
	
}

?>

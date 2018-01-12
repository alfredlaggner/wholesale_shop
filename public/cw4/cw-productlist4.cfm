<cfsilent><!---==========================================================Application: Cartweaver 4 ColdFusionCopyright 2002 - 2012, All Rights ReservedDeveloper: Application Dynamics, Inc. | Cartweaver.comLicensing: http://www.cartweaver.com/eulaSupport: http://www.cartweaver.com/support==========================================================File: cw-productList.cfmFile Date: 2012-02-13Description: shows product listings and search results==========================================================---><!--- default url variables ---><cfparam name="url.category" default="17"><cfparam name="url.secondary" default=""><cfparam name="url.keywords" default=""><cfparam name="url.page" default="1"><cfparam name="url.showall" default="0"><cfif not (url.showall eq 'true' or url.showall eq 1)>	<cfset url.showall = 0></cfif><cfif not isNumeric(url.page)>	<cfset url.page = 1></cfif><!--- sorting vars ---><cfparam name="session.cwclient.cwProductSortBy" default="sort"><cfparam name="session.cwclient.cwProductSortDir" default="asc"><cfparam name="session.cwclient.cwProductPerPage" default="4"><cfparam name="url.sortby" default="#session.cwclient.cwProductSortBy#"><cfparam name="url.sortdir" default="#session.cwclient.cwProductSortDir#"><cfparam name="url.perpage" default="#session.cwclient.cwProductPerPage#"><!--- page variables passed to search functioncan be overridden per page or passed in via URL ---><cfparam name="request.cwpage.categoryName" default="Featured Items"><cfparam name="request.cwpage.categoryID" default="17"><cfparam name="request.cwpage.secondaryName" default=""><cfparam name="request.cwpage.secondaryID" default=""><cfparam name="request.cwpage.keywords" default="#url.keywords#"><cfparam name="request.cwpage.resultsPage" default="#url.page#"><cfparam name="request.cwpage.resultsMaxRows" default="1"><cfparam name="request.cwpage.showAll" default="#url.showall#"><cfparam name="request.cwpage.sortBy" default="#url.sortby#"><cfparam name="request.cwpage.sortDir" default="#url.sortdir#"><cfparam name="request.cwpage.storeLinkText" default="#application.cw.companyName#"><cfparam name="primaryText" default=""><cfparam name="secondaryText" default=""><!--- if using sort order default, force 'ascending' order (1-9999) ---><cfif request.cwpage.sortBy is 'sort'>	<cfset request.cwpage.sortDir = 'asc'></cfif><!--- form and link actions ---><cfparam name="request.cwpage.hrefUrl" default="#trim(application.cw.appCwStoreRoot)##request.cw.thisPage#"><cfparam name="request.cwpage.adminUrlPrefix" default=""><!--- set up sortable links ---><cfparam name="application.cw.appDisplayProductSort" default="true"><cfparam name="request.cwpage.showSortLinks" default="#application.cw.appDisplayProductSort#"><!--- toggle sort direction ---><cfif request.cwpage.showSortLinks>	<cfif request.cwpage.sortDir is 'asc'>		<cfset newSortDir = 'desc'>	<cfelse>		<cfset newSortDir = 'asc'>	</cfif></cfif><!--- verify sortby is allowed ---><cfif not listFindNoCase('name,price,id',request.cwpage.sortBy)>	<cfset request.cwpage.sortBy = 'sort'></cfif><!--- verify per page is numeric, and one of our specified values ---><cfif not (isNumeric(request.cwpage.resultsMaxRows) AND listFind(application.cw.productPerPageOptions,request.cwpage.resultsMaxRows))>	<cfset request.cwpage.resultsMaxRows = application.cw.appDisplayPerPage></cfif><!--- set up link to edit admin product listing (if logged in) ---><cfparam name="application.cw.adminProductLinksEnabled" default="true"><!--- set up add to cart in listings ---><cfparam name="application.cw.appDisplayListingAddToCart" default="false"><!--- defaults for product search ---><cfparam name="request.cwpage.productsPerRow" default="#application.cw.appDisplayColumns#"><!--- clean up form and url variables ---><cfinclude template="cwapp/inc/cw-inc-sanitize.cfm"><!--- CARTWEAVER REQUIRED FUNCTIONS ---><cfinclude template="cwapp/inc/cw-inc-functions.cfm"><!--- page variables - request scope can be overridden per product as neededparams w/ default values are in application.cfc ---><cfset request.cwpage.useAltPrice = application.cw.adminProductAltPriceEnabled><cfset request.cwpage.altPriceLabel = application.cw.adminLabelProductAltPrice><cfset request.cwpage.imageZoom = application.cw.appEnableImageZoom><cfset request.cwpage.continueShopping = application.cw.appActionContinueShopping><!--- address used for redirection ---><cfset request.cwpage.relocateUrl = application.cw.appSiteUrlHttp><!--- address for continue shopping ---><cfparam name="request.cwpage.returnUrl" default="#request.cwpage.urlResults#"><!--- BASE URL ---><!--- get the vars to keep by omitting the ones we don't want repeated ---><cfset varsToKeep = CWremoveUrlVars("sortby,sortdir,perpage,showall,page,maxrows,submit,userconfirm,useralert")><!--- create the base url out of serialized url variables---><cfparam name="request.cwpage.baseUrl" default="#CWserializeUrl(varsToKeep,request.cwpage.urlResults)#">	<cfif request.cwpage.baseUrl contains "=">		<cfset request.cwpage.baseUrl = request.cwpage.baseUrl & "&">	</cfif><!--- persist showall for sorting ---><cfset request.cwpage.baseSortUrl = request.cwpage.baseUrl & 'showall=#request.cwpage.showAll#'>	<cfif not right(request.cwpage.baseSortUrl,1) is "&">		<cfset request.cwpage.baseSortUrl = request.cwpage.baseSortUrl & "&">	</cfif><!--- handle show all / paging (url.showall) ---><cfif request.cwpage.showAll is true>	<cfset request.cwpage.resultsPage = 1>	<cfset request.cwpage.maxproducts = 1><cfelse>	<cfset request.cwpage.maxproducts = request.cwpage.resultsMaxRows></cfif><!--- PRODUCT SEARCH QUERY ---><cfset products = CWqueryProductSearch(	category="17",	secondary="0",	keywords="",	start_page="1",	max_rows="1",	match_type="#application.cw.appSearchMatchType#"	)><cfset idlist = products.idlist><cfset productCount = products.count><!--- if only one is found, direct to that page ---><cfif productCount is 0 and listLen(idlist) is 0>	<cflocation url="#request.cwpage.urlDetails#?product=#idList#" addtoken="no"></cfif><!--- style width for results ---><cfset listingW = 100/request.cwpage.productsPerRow & '%'><!--- javascript for form sort links ---><cfsavecontent variable="headcontent"><cfif application.cw.appDisplayProductSortType is 'select' and request.cwpage.showSortLinks>	<script type="text/javascript">			jQuery(document).ready(function(){			jQuery('select.listingSortSelect,select.listingPerPage').change(function(){			var submitUrl = jQuery(this).children('option:selected').val();			window.location=submitUrl;			});		});	</script></cfif></cfsavecontent><!--- send to head of page ---><cfhtmlhead text="#headcontent#"></cfsilent><!--- /////// START OUTPUT /////// ---><!--- show listings ---><div id="CWlistings" class="CWcontent">	<!-- category/secondary/product name -->	<cfif request.cwpage.categoryID gt 0 and len(trim(request.cwpage.categoryName))		AND (		application.cw.appEnableCatsRelated eq 'true'		OR		(application.cw.appEnableCatsRelated eq 'false' and request.cwpage.secondaryID is 0)		)>		<cfsavecontent variable="primaryText">		<cfoutput>			<a href="#request.cwpage.urlResults#?category=#request.cwpage.categoryID#">#request.cwpage.categoryID#</a>		</cfoutput>		</cfsavecontent>	<cfelseif len(trim(request.cwpage.storeLinkText))>		<cfsavecontent variable="primaryText">		<cfoutput>			<a href="#request.cwpage.urlResults#">#request.cwpage.storeLinkText#</a>		</cfoutput>		</cfsavecontent>	</cfif>	<cfif request.cwpage.secondaryID gt 0 and len(trim(request.cwpage.secondaryName))>		<cfsavecontent variable="secondaryText">		<cfoutput>			<a href="#request.cwpage.urlResults#?<cfif request.cwpage.categoryID gt 0>category=#request.cwpage.categoryID#&</cfif>secondary=#request.cwpage.secondaryID#">#request.cwpage.secondaryName#</a>		</cfoutput>		</cfsavecontent>	</cfif>	<!--- category / subcategory descriptions --->	<cfset listingPrimaryText = CWgetListingText(category_id=request.cwpage.categoryID)>	<cfset listingSecondaryText = CWgetListingText(secondary_id=request.cwpage.secondaryID)>	<!--- primary description --->	<!--- if related categories are selected, primary description is shown only for 'all' in category (no secondary category) --->	<cfif (application.cw.appEnableCatsRelated eq 'true' AND len(trim(listingSecondaryText)) eq 0 AND len(trim(listingPrimaryText)) gt 0)		OR application.cw.appEnableCatsRelated eq 'false' AND len(trim(listingPrimaryText)) gt 0>		<div class="CWlistingText" id="CWprimaryDesc">			<cfoutput>#listingPrimaryText#</cfoutput>		</div>	</cfif>	<!--- secondary description --->	<cfif len(trim(listingSecondaryText)) gt 0>		<div class="CWlistingText" id="CWsecondaryDesc">			<cfoutput>#listingSecondaryText#</cfoutput>		</div>	</cfif>	<!--- if products were found --->	<!--- if no products are returned --->	<cfif products.count eq 0>		<div class="CWalertBox">			<cfoutput>				No Products Found<cfif len(trim(request.cwpage.keywords))> for search term "#request.cwpage.keywords#"</cfif>				<br><br><a href="#request.cwpage.hrefUrl#">View All Products</a>			</cfoutput>		</div>	</cfif>	<!--- loop list of IDs from function above --->	<cfset loopCt = 1>	<cfloop list="#idList#" index="pp">		<!--- count output for insertion of breaks or other formatting --->		<!--- show the product include --->		<div class="CWlistingBox"  style="width:25%; float:left; margin-left:10px">
			<!--- product preview --->			<cfmodule			template="cwapp/mod/cw-mod-productpreview.cfm"			product_id="#pp#"			add_to_cart="false"			show_qty="false"			show_description="false"			show_image="true"			show_price="true"			image_class="CWimgResults"			image_position="above"			title_position="above"			details_link_text="&raquo; Details"			>			<!--- edit product link --->			<cfif application.cw.adminProductLinksEnabled				and isDefined('session.cw.loggedIn') and session.cw.loggedIn is '1'				and isDefined('session.cw.accessLevel') and	listFindNoCase('developer,merchant',session.cw.accessLevel)>				<cfoutput>					<p><a href="#request.cwpage.adminUrlPrefix##application.cw.appCwAdminDir#product-details.cfm?productid=#pp#" class="CWeditProductLink" title="Edit Product"><img alt="Edit Product" src="#request.cwpage.adminUrlPrefix##application.cw.appCwAdminDir#img/cw-edit.gif"></a></p>				</cfoutput>			</cfif>		</div>		<!--- divide rows --->		<cfif loopCt mod request.cwpage.productsPerRow is 0>			<div class="CWclear"></div>		</cfif>		<!--- advance counter --->		<cfset loopCt = loopCt + 1>	</cfloop><!--- paging and product count --->	<!-- clear floated content -->	<br /><div class="CWclear"></div></div>
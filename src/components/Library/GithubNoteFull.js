import React from 'react';
import { Link } from 'react-router';

class GithubNoteFull extends React.Component {
	
  render() { 
	let note = this.props.data;
	  
	return (
		<div>
		<hr />
			<div className="container">
				<Link to={this.props.backURL} > BACK </Link>
			</div>
		<hr />
	<div className="container-fluid">
	<div id="studies" className="row site">
		<div id="sidebar" className="col-md-3" style={{position: "fixed55", bottom: "0px"}}>
			<div className="sidebar">
				<div id="masthead" className="site-header" role="banner">		
					<img className="study-default-image" src="/svg/be-logo.svg" name="Bible exchange" alt="Bible exchange" />
						
					<div className="sidebar-block orangeBG">
						<h2>Author</h2>
						<p> 
						{/*<-- Author-->*/}			
						</p>
						<p className="small">
						{/*<-- Edited by-->	*/}		
						</p>
					</div>
					<a id="secondary-toggle" data-toggle="collapse" href="#sidebar-collapse" aria-expanded="false" aria-controls="collapseExample" className="visible-xs visible-sm">
						<div className="sidebar-block greenBG">
							<h2><span className="glyphicon glyphicon-menu-down" aria-hidden="true"></span></h2>
						</div>
					</a>		
				</div>
	
				<div id="secondary" className="secondary">
					<div id="sidebar-collapse" className="collapse in">	
						<div className="sidebar-block blueBG">
							<h2><span className="glyphicon glyphicon-time" aria-hidden="true"></span></h2>
							<p>{/*<!-- Updated date -->*/}</p>
							<p className="small">{/*<!-- Created date -->*/}</p>
						</div>
							
						<div className="sidebar-block greenBG">
							<h2>Share</h2>
							<span className="study-sharing">									
							<div className="social-sharing center">
{/*
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style={{display: "none"}}>
<symbol id="pinterest" viewBox="0 0 400 400">
<path d="M200,0.001 C89.543,0.001 -0,89.544 -0,200.001 C-0,284.728 52.715,357.097 127.113,386.238 C125.365,370.415 123.786,346.143 127.808,328.865 C131.441,313.26 151.26,229.452 151.26,229.452 C151.26,229.452 145.277,217.474 145.277,199.761 C145.277,171.953 161.397,151.19 181.466,151.19 C198.529,151.19 206.771,164.003 206.771,179.363 C206.771,196.523 195.847,222.178 190.207,245.951 C185.496,265.863 200.19,282.098 219.823,282.098 C255.373,282.098 282.696,244.612 282.696,190.51 C282.696,142.624 248.289,109.142 199.154,109.142 C142.248,109.142 108.846,151.827 108.846,195.936 C108.846,213.125 115.469,231.558 123.73,241.578 C125.364,243.559 125.603,245.294 125.116,247.312 C123.599,253.634 120.225,267.219 119.564,269.997 C118.691,273.658 116.663,274.434 112.875,272.671 C87.894,261.042 72.278,224.522 72.278,195.19 C72.278,132.101 118.118,74.162 204.424,74.162 C273.802,74.162 327.72,123.598 327.72,189.67 C327.72,258.6 284.26,314.072 223.94,314.072 C203.671,314.072 184.621,303.543 178.1,291.105 C178.1,291.105 168.071,329.293 165.641,338.648 C161.123,356.02 148.935,377.795 140.781,391.079 C159.495,396.874 179.382,399.999 200,399.999 C310.457,399.999 400,310.457 400,200.001 C400,89.544 310.457,0.001 200,0.001"></path>				
</symbol>
<symbol id="facebook" viewBox="400 0 400 400">
<path d="M777.924,-0 L422.076,-0 C409.881,-0 400,9.888 400,22.091 L400,378.183 C400,390.384 409.881,400.275 422.076,400.275 L613.652,400.275 L613.652,245.268 L561.525,245.268 L561.525,184.858 L613.652,184.858 L613.652,140.308 C613.652,88.607 645.207,60.455 691.296,60.455 C713.372,60.455 732.348,62.1 737.876,62.835 L737.876,116.865 L705.912,116.88 C680.846,116.88 675.993,128.799 675.993,146.289 L675.993,184.858 L735.772,184.858 L727.988,245.268 L675.993,245.268 L675.993,400.275 L777.924,400.275 C790.116,400.275 800,390.384 800,378.183 L800,22.091 C800,9.888 790.116,-0 777.924,-0"></path>
</symbol>
<symbol id="twitter" viewBox="800 0 400 400">
<path d="M1076.909,46.72 C1100.517,46.72 1121.85,56.131 1136.824,71.189 C1155.52,67.714 1173.088,61.265 1188.947,52.387 C1182.818,70.479 1169.803,85.663 1152.855,95.253 C1169.46,93.38 1185.279,89.215 1200,83.053 C1188.995,98.591 1175.078,112.237 1159.042,123.162 C1159.199,126.484 1159.279,129.825 1159.279,133.185 C1158.985,144.897 1159.128,148.626 1157.113,162.285 C1146.625,233.385 1099.82,299.049 1031.302,331.153 C998.502,346.522 969.031,351.762 932.765,353.551 L932.506,353.554 L920.94,353.554 C877.339,353.071 836.871,340.358 800,318.878 L800,318.836 C806.466,319.609 812.983,319.819 819.493,319.909 C857.949,319.909 893.342,307.522 921.434,286.741 C885.516,286.116 855.202,263.715 844.758,232.932 C849.768,233.837 854.911,234.322 860.2,234.322 C867.687,234.322 874.938,233.375 881.826,231.604 C844.275,224.487 815.982,193.171 815.982,155.63 C815.982,155.304 815.982,154.979 815.988,154.656 C827.056,160.459 839.712,163.945 853.168,164.347 C831.143,150.453 816.651,126.737 816.651,99.856 C816.651,85.657 820.699,72.347 827.764,60.903 C868.249,107.78 928.731,138.626 996.95,141.857 C995.551,136.187 994.824,130.273 994.824,124.2 C994.824,81.412 1031.577,46.72 1076.909,46.72 z"></path>			
</symbol>
<symbol id="gplus" viewBox="1200 0 400 400">
<path d="M1442.803,9.11 C1442.803,9.11 1411.935,27.2 1411.935,27.2 L1381.118,27.2 C1384.257,29.157 1387.787,32.014 1391.71,35.766 C1395.474,39.683 1399.165,44.497 1402.776,50.208 C1406.226,55.593 1409.285,61.956 1411.954,69.298 C1414.149,76.642 1415.25,85.208 1415.25,95 C1414.952,112.951 1411.007,127.308 1403.411,138.077 C1399.687,143.302 1395.74,148.112 1391.573,152.52 C1386.957,156.925 1382.044,161.414 1376.833,165.981 C1373.854,169.083 1371.101,172.588 1368.571,176.505 C1365.594,180.586 1364.104,185.318 1364.104,190.703 C1364.104,195.925 1365.63,200.247 1368.686,203.674 C1371.28,206.941 1373.801,209.794 1376.247,212.242 C1376.247,212.242 1393.199,226.192 1393.199,226.192 C1403.736,234.844 1412.976,244.385 1420.918,254.829 C1428.402,265.436 1432.299,279.307 1432.603,296.44 C1432.603,320.751 1421.911,342.29 1400.528,361.057 C1378.353,380.475 1346.354,390.511 1304.54,391.164 C1269.536,390.836 1243.399,383.344 1226.137,368.687 C1208.715,355.003 1200,338.636 1200,319.581 C1200,310.295 1202.834,299.955 1208.501,288.554 C1214.001,277.15 1223.958,267.133 1238.371,258.507 C1254.558,249.221 1271.562,243.033 1289.373,239.938 C1307.016,237.329 1321.667,235.868 1333.328,235.541 C1329.724,230.783 1326.513,225.696 1323.695,220.281 C1320.404,215.032 1318.762,208.714 1318.762,201.329 C1318.762,196.902 1319.386,193.207 1320.64,190.255 C1321.736,187.138 1322.754,184.269 1323.695,181.646 C1318.015,182.3 1312.664,182.625 1307.637,182.625 C1281.035,182.3 1260.756,173.898 1246.809,157.417 C1232.208,142.082 1224.91,124.218 1224.91,103.823 C1224.91,79.185 1235.252,56.836 1255.938,36.764 C1270.146,25.02 1284.908,17.351 1300.224,13.759 C1315.383,10.663 1329.594,9.11 1342.858,9.11 L1442.803,9.11 z M1333.7,249.113 C1331.991,249.133 1332.825,249.127 1331.198,249.131 C1326.176,249.298 1321.171,249.754 1316.168,250.203 C1305.823,251.67 1295.242,254.035 1284.425,257.3 C1281.876,258.281 1278.296,259.748 1273.683,261.71 C1269.067,263.829 1264.375,266.851 1259.602,270.766 C1254.985,274.843 1251.089,279.904 1247.905,285.944 C1244.244,292.309 1242.416,299.978 1242.416,308.957 C1242.416,326.581 1250.369,341.105 1266.283,352.534 C1281.4,363.956 1302.086,369.831 1328.342,370.16 C1351.893,369.831 1369.874,364.61 1382.284,354.491 C1394.376,344.532 1400.425,331.72 1400.425,316.055 C1400.425,303.325 1396.285,292.226 1388.013,282.764 C1379.26,273.784 1365.578,262.77 1346.959,249.713 C1343.776,249.384 1340.039,249.224 1335.743,249.224 C1335.063,249.154 1334.383,249.114 1333.7,249.113 z M1311.928,25.731 C1298.385,26.059 1287.121,31.537 1278.147,42.164 C1270.576,53.285 1266.954,65.712 1267.28,79.442 C1267.28,97.592 1272.567,116.481 1283.149,136.1 C1288.268,145.257 1294.88,153.024 1302.978,159.398 C1311.075,165.779 1320.332,168.963 1330.745,168.963 C1343.901,168.474 1354.863,163.732 1363.635,154.736 C1367.863,148.361 1370.583,141.823 1371.791,135.117 C1372.514,128.417 1372.88,122.776 1372.88,118.195 C1372.88,98.411 1367.84,78.463 1357.761,58.35 C1353.035,48.704 1346.816,40.856 1339.098,34.806 C1331.221,29.085 1322.167,26.059 1311.928,25.731 z M1546.155,111.677 L1546.155,165.254 L1598.718,165.254 L1598.718,165.521 L1600,165.521 C1600,165.522 1600,196.29 1600,196.29 L1546.155,196.29 L1546.155,248.853 C1546.155,248.853 1515.387,248.853 1515.387,248.853 L1515.387,196.29 L1462.824,196.29 L1462.824,195.153 L1462.492,195.153 C1462.492,195.153 1462.492,165.254 1462.492,165.254 L1515.387,165.254 L1515.387,111.677 L1546.155,111.677 z"></path>
</symbol>
</svg>
*/}          
									<a className="social-sharing-buttons social-twitter" href="https://twitter.com/intent/tweet?text=Check out this note at http://bible.exchange/&amp;url=http://bible.exchange/study/18-benefits-of-having-been-tested-in-battle&amp;via=bible_exchange" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;">
									{/*<svg className="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#twitter"></use></svg>*/}
									</a>
									<a className="social-sharing-buttons social-facebook" href="http://www.facebook.com/sharer/sharer.php?u=http://bible.exchange/study/18-benefits-of-having-been-tested-in-battle" onclick="window.open(this.href, 'mywin',
								'left=50,top=50,width=600,height=350,toolbar=0'); return false;">
									{/*<svg className="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#facebook"></use></svg>*/}
									</a>
									<a className="social-sharing-buttons social-gplus" href="http://plus.google.com/share?url=http://bible.exchange/study/18-benefits-of-having-been-tested-in-battle" onclick="window.open(this.href, 'mywin',
								''); return false;">
									{/*<svg className="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#gplus"></use></svg>*/}
									</a>
									<a className="social-sharing-buttons social-pinterest" href="http://pinterest.com/pin/create/button/?url=http://bible.exchange/study/18-benefits-of-having-been-tested-in-battle&amp;media=http://bible.exchange/images/be_logo.png&amp;description=Benefits+of+having+Been+Tested+in+Battle posted by http://bible.exchange/@stephenjr" onclick="window.open(this.href, 'mywin',
								'left=50,top=50,width=600,height=350,toolbar=0'); return false;">
									{/*<svg className="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#pinterest"></use></svg>*/}
									</a>
								</div>					
							</span>
						</div>
							
						<div className="sidebar-block blueBG"></div>
						<div className="sidebar-block greenBG"></div>
					</div>	
				</div>
			</div>
		</div>
		
		<div id="content" className="site-content col-md-9 col-md-offset-3">

			<div className="textbook" style={{minHeight:"1200px"}}>		  
				<div>
					<div className="h1-box">
						<h1>{note.title}
							<div className="center">
								<small>{/*<!--  subtitle -->*/}</small>
							</div>
						</h1>
						<div className="h1-underline"></div>
						<div className="h1-underline"></div>
						<div className="h1-underline"></div>
					</div>	
				</div>		
				<p className="long-description"></p>
				<hr />
				<hr />
				<article><div dangerouslySetInnerHTML={note.body}></div></article>	
			</div>			 	
			{/*
			<div className="panel panel-default panel-study-green">
				<div className="panel-heading">
					<h2 className="panel-title">Comments</h2>
				</div>
				<div className="panel-body">
					<p><em className="text-muted">No comments, yet.</em></p>
				</div>
			</div>		
			*/}
		</div>
	</div>
</div>
</div>);
	}
}
module.exports = GithubNoteFull;
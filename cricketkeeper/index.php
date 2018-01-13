<!DOCTYPE html>
<!--[if IE 8]>
<html xmlns="http://www.w3.org/1999/xhtml" class="ie8 wp-toolbar"  lang="en-US">
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" class="wp-toolbar"  lang="en-US">
<!--<![endif]-->
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<style>
	body, html {
		height:100%;
		width:100%;
		margin:0;
		padding:0;
		font-size:1em;
		background: black url(images/bg.jpg);
		background-repeat:no-repeat;
		background-size: contain;
		background-position: center center;
	}
	#scoreFrame {
		width:90%;
		height:88%;
		font-weight:bold;
		font-family:verdana;
		margin: 0 auto;
		padding: 4% 0;
	}

	#scoreFrame div#scoreFrameInner {
		width:100%;
		height:100%;
		vertical-align:middle;
		border-radius: 15px;
		overflow:hidden;
		background: url("images/globe.png") no-repeat scroll right top / 100% 100% transparent;
		background-color: rgba(255,255,255,.85);
	}

	#scoreFrame div {
		display:inline-block;
		height:100%;
	}
	#scoreFrame div.row {
		display:block;

		border-bottom:solid 1px gray;

		height:11.1%;
	}
	#scoreFrame div.row.title {
/*		height:auto;
*/
	}
	.target {
		width:45%;
	}

	#scoreFrame div.player_spacer {
		width:10%;
		text-align:center;
/*		background-color:rgba(255,255,255,.75);*/
		color:#666;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25), 0 1px 0 rgba(255, 255, 255, 0.8);
		height:100%;
        vertical-align: middle;
 	}
	#scoreFrame div.player_spacer_inner {
		font-size: .7em;
		height:auto;
		background:transparent;
	}
	.title {
		background-color:#f0f0f0;
		font-size: .7em;
		vertical-align:middle;
/*
		border-bottom: solid .05em black;
*/
		color:#444444;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25), 0 1px 0 rgba(255, 255, 255, 0.8);
	}
	.score {
		width:90%;
		text-align:center;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25), 0 1px 0 rgba(255, 255, 255, 0.8);
	}
	.minus {
		width:10%;
		text-align:center;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25), 0 1px 0 rgba(255, 255, 255, 0.8);
	}
	.scorePlayerSpacerTop {
		background-image: url(/images/logo4.png);
		background-size: contain;
		background-repeat: no-repeat;
		background-position: center center;
	}
	.header {
        vertical-align:middle;
	}
	.header input {
		text-align:center;
		background:transparent;
		border:none;
		color:#444444;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25), 0 1px 0 rgba(255, 255, 255, 0.8);
		font-size:.8em;
		vertical-align: middle;
		height:100%;
	}
</style>

<script>
	jQuery(document).ready(function() {
                var $body = jQuery('body'); //Cache this for performance

                var setBodyScale = function() {
                    var scaleSource = $body.width(),
                        scaleFactor = 0.25,
                        maxScale = 375,
                        minScale = 30; //Tweak these values to taste

                    var fontSize = scaleSource * scaleFactor; //Multiply the width of the body by the scaling factor:

                    if (fontSize > maxScale) fontSize = maxScale;
                    if (fontSize < minScale) fontSize = minScale; //Enforce the minimum and maximums

                    jQuery('body').css('font-size', fontSize + '%');
                }

                jQuery(window).resize(function(){
                    setBodyScale();
                });

                //Fire it when the page first loads:
                setBodyScale();

		  jQuery('.minus:not(.header)').click(function() {

			theVal   = parseInt(jQuery(this).attr('data'));
			player   = jQuery(this).attr('class').substring(6,90);
			el = jQuery('.target.'+player+'[data='+theVal+']');
			theTotal = parseInt(jQuery(el).attr('data-total'));


			if (theTotal == theVal) {
				theTotal = 3;
			} else if (theTotal > theVal) {
				theTotal = theTotal - theVal;
            } else if (theTotal > 0) {
				theTotal--;
			} else {
				theTotal = 0;
			}

//            alert('theTotal='+theTotal+'... theVal='+theVal+'... player='+player+"... theTotalOtherPlayer="+theTotalOtherPlayer);

			jQuery(el).attr('data-total', theTotal);

			els = jQuery('.score.'+player+'[data='+theVal+']');
		    if (theTotal == 0) {
				jQuery(el).css('background-color', 'transparent');
		        jQuery(els).html("0");
			} else if (theTotal == 1) {
		        jQuery(els).html("<img src='images/1.png' alt='' title='' style='width:auto;height:100%;vertical-align:middle;' />");
				jQuery(el).css('background-color', 'rgba(0,255,0,.5)');
			} else if (theTotal == 2) {
		        jQuery(els).html("<img src='images/2.png' alt='' title='' style='width:auto;height:100%;vertical-align:middle;' />");
				jQuery(el).css('background-color', 'rgba(255,255,0,.5)');
			} else if (theTotal == 3) {
		        jQuery(els).html("<img src='images/3.png' alt='' title='' style='width:auto;height:100%;vertical-align:middle;' />");
				jQuery(el).css('background-color', 'rgba(255,0,0,.5)');
			} else if (theTotal > 3) {
		        jQuery(els).html("<img src='images/0.png' alt='' title='' style='width:auto;height:100%;vertical-align:middle;' />"+theTotal);
				jQuery(el).css('background-color', 'rgba(255,0,0,.5)');
			}

			computeTotals();

			return false;
		  });

		  jQuery('.target:not(.header)').click(function() {
			theTotal = parseInt(jQuery(this).attr('data-total'));
			theVal   = parseInt(jQuery(this).attr('data'));
			player   = jQuery(this).attr('class').substring(7,90);
			playerOther= "p_two";
			if (player == 'p_two') {
				playerOther = "p_one";
			}
            theTotalOtherPlayer = parseInt(jQuery('.target.'+playerOther+'[data='+theVal+']').attr('data-total'));

			if (theTotalOtherPlayer < 3) {
				if (theTotal == 3) {
					theTotal = theVal;
				} else if (theTotal > 3) {
					theTotal = theTotal + theVal;
				} else {
					theTotal++;
				}
			} else if (theTotal < 3) {
				theTotal++;
			}

			jQuery(this).attr('data-total', theTotal);

//            alert('theTotal='+theTotal+'... theVal='+theVal+'... player='+player+"... theTotalOtherPlayer="+theTotalOtherPlayer);

			el = jQuery('.score.'+player+'[data='+theVal+']');
		    if (theTotal == 0) {
				jQuery(this).css('background-color', '#ffffff');
			} else if (theTotal == 1) {
		        jQuery(el).html("<img src='images/1.png' alt='' title='' style='width:auto;height:100%;vertical-align:middle;' />");
				jQuery(this).css('background-color', 'rgba(0,255,0,.5)');
			} else if (theTotal == 2) {
		        jQuery(el).html("<img src='images/2.png' alt='' title='' style='width:auto;height:100%;vertical-align:middle;' />");
				jQuery(this).css('background-color', 'rgba(255,255,0,.5)');
			} else if (theTotal == 3) {
		        jQuery(el).html("<img src='images/3.png' alt='' title='' style='width:auto;height:100%;vertical-align:middle;' />");
				jQuery(this).css('background-color', 'rgba(255,0,0,.5)');
			} else if (theTotal > 3) {
		        jQuery(el).html("<img src='images/0.png' alt='' title='' style='width:auto;height:100%;vertical-align:middle;' />"+theTotal);
				jQuery(this).css('background-color', 'rgba(255,0,0,.5)');
			}

			computeTotals();
		});
	});

	function computeTotals() {
		total = 0;
		els = jQuery('.target.p_one').not('.total, .header').each(function() {
			curVal = parseInt(jQuery(this).attr('data-total'));
			if (curVal > 3) {
				total += curVal;
			}
		});
		jQuery('.score.p_one.total').html(total);

		total = 0;
		els = jQuery('.target.p_two').not('.total, .header').each(function() {
			curVal = parseInt(jQuery(this).attr('data-total'));
			if (curVal > 3) {
				total += curVal;
			}
		});
		jQuery('.score.p_two.total').html(total);
	}
</script>
</head>
<body>
<div id='scoreFrame'>
	<div id='scoreFrameInner'>
		<div class='row title'><div class='target p_one header'><div class='minus p_one header'>&nbsp;</div><div class='score p_one header'><input type='text' value='PLAYER ONE' onClick="this.select();"/></div></div><div class='player_spacer header scorePlayerSpacerTop'>&nbsp;</div><div class='target p_two header'><div class='score p_two header'><input type='text' value='PLAYER TWO' onClick="this.select();" /></div><div class='minus p_two header'>&nbsp;</div></div></div>
		<div class='row'><div class='target p_one' data='20' data-total='0'><div class='minus p_one' data='20'>-</div><div class='score p_one' data='20'>0</div></div><div class='player_spacer'><div class='player_spacer_inner'>20</div></div><div class='target p_two' data='20' data-total='0'><div class='score p_two' data='20'>0</div><div class='minus p_two' data='20'>-</div></div></div>
		<div class='row'><div class='target p_one' data='19' data-total='0'><div class='minus p_one' data='19'>-</div><div class='score p_one' data='19'>0</div></div><div class='player_spacer'><div class='player_spacer_inner'>19</div></div><div class='target p_two' data='19' data-total='0'><div class='score p_two' data='19'>0</div><div class='minus p_two' data='19'>-</div></div></div>
		<div class='row'><div class='target p_one' data='18' data-total='0'><div class='minus p_one' data='18'>-</div><div class='score p_one' data='18'>0</div></div><div class='player_spacer'><div class='player_spacer_inner'>18</div></div><div class='target p_two' data='18' data-total='0'><div class='score p_two' data='18'>0</div><div class='minus p_two' data='18'>-</div></div></div>
		<div class='row'><div class='target p_one' data='17' data-total='0'><div class='minus p_one' data='17'>-</div><div class='score p_one' data='17'>0</div></div><div class='player_spacer'><div class='player_spacer_inner'>17</div></div><div class='target p_two' data='17' data-total='0'><div class='score p_two' data='17'>0</div><div class='minus p_two' data='17'>-</div></div></div>
		<div class='row'><div class='target p_one' data='16' data-total='0'><div class='minus p_one' data='16'>-</div><div class='score p_one' data='16'>0</div></div><div class='player_spacer'><div class='player_spacer_inner'>16</div></div><div class='target p_two' data='16' data-total='0'><div class='score p_two' data='16'>0</div><div class='minus p_two' data='16'>-</div></div></div>
		<div class='row'><div class='target p_one' data='15' data-total='0'><div class='minus p_one' data='15'>-</div><div class='score p_one' data='15'>0</div></div><div class='player_spacer'><div class='player_spacer_inner'>15</div></div><div class='target p_two' data='15' data-total='0'><div class='score p_two' data='15'>0</div><div class='minus p_two' data='15'>-</div></div></div>
		<div class='row'><div class='target p_one' data='25' data-total='0'><div class='minus p_one' data='25'>-</div><div class='score p_one' data='25'>0</div></div><div class='player_spacer'><div class='player_spacer_inner'>B</div></div><div class='target p_two' data='25' data-total='0'><div class='score p_two' data='25'>0</div><div class='minus p_two' data='25'>-</div></div></div>
		<div class='row total' style='border-bottom:none;border-top:solid 1px gray;'><div class='target p_one total'><div class='minus p_one total' style='height:100%;'>&nbsp;</div><div class='score p_one total'>0</div></div><div class='player_spacer total'><div class='player_spacer_inner'>T</div></div><div class='target p_two total'><div class='score p_two total'>0</div><div class='minus p_two total' style='height:100%;'>&nbsp;</div></div></div>
	</div>
</div>
</body>
</html>
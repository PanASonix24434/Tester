<style type="text/css">
	/* Paste this css to your style sheet file or under head tag */
	/* This only works with JavaScript, 
	if it's not present, don't show loader */
	.no-js #loading-div { display: none;  }
	.js #loading-div { display: block; position: absolute; left: 100px; top: 0; }
	.se-pre-con {
	    position: fixed;
	    left: 0px;
	    top: 0px;
	    width: 100%;
	    height: 100%;
	    z-index: 9999;
	    background: rgba(0,0,0,0.8);
	}
</style>

<div id="loading-div" class="se-pre-con text-center hidden" style="height: 100%;">
    <p id="loading-message" style="position: relative; top: calc(35%); color:#fff;">
    	<i class="fas fa-circle-notch fa-spin fa-4x fa-spin"></i><br />
    </p>
</div>
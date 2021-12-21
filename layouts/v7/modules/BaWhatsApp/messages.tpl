                   {foreach from=$MESSAGES item=message }
	                   {if $message['type'] == 'post'}
    		                <div class='chat-bubble ba-post'>
            		            <div class='my-mouth'></div>
        	        	        <div class='content'> {$message['content']}  </div>
    	                    	<div class='time'> {$message['time']} </div>
	                    	</div>
						{else}
            	    	    <div class='chat-bubble ba-get'>
                	            <div class='your-mouth'></div>
                    	        <h5>{$message['name']}</h5>
                        	    <div class='content'> {$message['content']} </div>
    	                        <div class='time'>  {$message['time']} </div>
		                    </div>
    	                {/if}
                    {/foreach}
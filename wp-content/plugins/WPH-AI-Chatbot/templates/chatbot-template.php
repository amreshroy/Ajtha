    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

<div class="chatbot-container lwh-open-cbot">
        <div class="custom-chatbot__image" style="display: block;" onclick="lwhOpenCbotToggleChat()">
            <dotlottie-player src="https://lottie.host/16dfd418-2a6d-4d32-bd85-a25dfbf46ba9/IjLZs82Ay5.json"
                background="transparent" speed="1" style="width: 90px; height: 90px;" loop autoplay></dotlottie-player>
        </div>
        <div class="custom-chatbot">

            <div class="chat">
                <div class="feedback-form">
                    <div class="feedback-header">
                        <p>Feedback</p>
                        <p class="feedback__modal-close" onclick="lwhOpenCbotremoveFeedbackModal()"><i class="fa-solid fa-xmark"></i></p>
                    </div>
                    <form onsubmit="lwhOpenCbotsendFeedback(event)">
                        <textarea name="feedback" id="feedback"  rows="4" required></textarea>
                        <button type="submit">Send Feedback</button>
                    </form>
                    
                </div>
                <div class="loading">
                    <p><i class="fa-solid fa-circle-notch fa-spin"></i></p>
                    <p>Wait a moment</p>
                </div>
                <div class="popup">
                    <p>Oops! Something went wrong!</p>
                </div>
                <div class="chat__header">
                    <div id="chat_header_name">
                        <div class="chat__title"> WPHub AI Chatbot
                        </div>
                        <div>
                            <div class="chat__status"><span></span> Offline</div>
                           
                        </div>
                    </div>
					<div id="chat_header_back" style="display: none">
						<button onclick="closeLeadForm()">
							
<i class="fa-solid fa-chevron-left" style></i>				              Back
						</button>
                    </div>
                    <div>
               
                        <div class="chat__close-icon" onclick="lwhOpenCbotToggleChat()">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </div>
                </div>
				<div class="lead-header-container" style="display: none">

                    </div>
                <div class="chat__messages">
                  
                </div>


                <div class="chat__input-area">
                    <div class="selected-image-container">

                    </div>
<form id="messageForm" onsubmit="lwhOpenCbotonFormSubmit(event)">
    <div class="form-outer" id="form-outer">
        <div class="input" id="input-with-message">
            <!-- Lead Capture Fields -->
            <div id="leadCaptureFields">
                <div class="form-group">
					                    <input type="text" id="name" name="name" placeholder="" class="wph-input" required>

                    <label for="name" class="wph-label">Name</label>
                </div>

                <div class="form-group">
					                    <input type="email" id="email" name="email" placeholder="" class="wph-input" required>

                    <label for="email" class="wph-label">Email</label>
                </div>

                <div class="form-group">
					                    <input type="tel" id="phone" name="phone" placeholder="" class="wph-input" required>

                    <label for="phone" class="wph-label">Phone Number</label>
                </div>
            </div>
            
            <div class="form-group msg-input">
				                <input type="text" id="message" name="message" placeholder="" autocomplete="off" class="wph-input" required>

                <label for="message" class="wph-label">Message</label>
            </div>
			
        </div>
        
        <div class="button-div" id="button-div">
            <button type="submit" id="submit-btn">
                <i class="fa-solid fa-paper-plane"></i>
                <span style="display: none">Start Chat</span>
            </button>
        </div>

        <div class="button-start-div button-div" id="button-start-div">
            <button id="start-btn" onclick="displayLeadForm()">
                <i class="fa-solid fa-paper-plane"></i>
                <span>New Conversation</span>
            </button>
        </div>
    </div>
</form>




</div>
</div>
</div>
</div>
 <script>
        document.querySelectorAll('.wph-input').forEach((input) => {
            input.addEventListener('input', function() {
                if (this.value) {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });
        });
    </script>
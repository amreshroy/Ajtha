const apiUrl = chatbotConfig.apiUrl;
const botConfigurationUrl = chatbotConfig.configUrl;
const copyButtons = document.querySelectorAll('.lwh-open-cbot .copy-button');
const button = document.querySelector('.lwh-open-cbot #submit-btn');
let messageInput = document.querySelector('.lwh-open-cbot #message');
let content = [];
let botConfigData = '';
let conversationTranscript = [];
const chatbotImage = document.querySelector('.custom-chatbot__image');
const lead_id = Math.floor(Math.random() * 900000000000) + 100000000000;

function lwhOpenCbotToggleChat() {
  if (chatbotImage.style.display === "none" || chatbotImage.style.display === "") {
        chatbotImage.style.display = "block"; // Show the element
	  	customChatbot.style.display = 'none';

    } else {
        chatbotImage.style.display = "none"; // Hide the element
			  	customChatbot.style.display = 'block';

    }
	const chatWindow = document.querySelector(".lwh-open-cbot .chat");
    chatWindow.classList.toggle('show');
    if(chatWindow.classList.contains('show')){
        document.querySelector(".lwh-open-cbot .custom-chatbot").style.zIndex = '9999'
    }
    else{
        document.querySelector(".lwh-open-cbot .custom-chatbot").style.zIndex = '9998'
    }
}
let leadCaptured = false; // Flag to check if the lead is captured
const leadCaptureFields = document.getElementById('leadCaptureFields');
const formOuter = document.getElementById('form-outer');
const buttonDiv = document.getElementById('button-div');
const msgInput = document.querySelector('.form-group.msg-input');
const chatSec = document.querySelector('.lwh-open-cbot .chat__messages');
const buttonStartDiv = document.getElementById('button-start-div');
const inputWithMessage = document.getElementById('input-with-message');
const chatHeaderName = document.getElementById('chat_header_name');
const chatHeaderBack = document.getElementById('chat_header_back');
const chatShowDiv = document.querySelector('.chat');
const leadHeader = document.querySelector('.lead-header-container');
const customChatbot = document.querySelector('.custom-chatbot');

//Styling Condition
 if (!leadCaptured) {
	 		buttonDiv.style.display = 'none';
		inputWithMessage.style.display = 'none';
}
function displayLeadForm(){
	inputWithMessage.style.display = 'flex';
	buttonDiv.style.display = 'flex';
	buttonStartDiv.style.display = 'none';
	chatSec.style.display = "none";
	chatHeaderName.style.display = "none";
	chatHeaderBack.style.display= "block";
	chatShowDiv.classList.add("lead-form-open")
	leadHeader.style.display= "block";
}
function closeLeadForm(){
	inputWithMessage.style.display = 'none';
	buttonDiv.style.display = 'none';
	buttonStartDiv.style.display = 'flex';
	chatSec.style.display = "flex";
	chatHeaderName.style.display = "block";
	chatHeaderBack.style.display= "none";
		chatShowDiv.classList.remove("lead-form-open")
		leadHeader.style.display= "none";


}
// Function to autofill data if it exists in localStorage
function autofillLeadData() {
    const savedName = localStorage.getItem('lead_name');
    const savedEmail = localStorage.getItem('lead_email');
    const savedPhone = localStorage.getItem('lead_phone');
    
    if (savedName) document.getElementById('name').value = savedName;
    if (savedEmail) document.getElementById('email').value = savedEmail;
    if (savedPhone) document.getElementById('phone').value = savedPhone;
}



// Call autofillLeadData when the page loads or when form is ready
document.addEventListener("DOMContentLoaded", autofillLeadData);

function lwhOpenCbotonFormSubmit(event, userMessage) {
    event.preventDefault();
    if (button.disabled) return;
    let message;
    // Lead capture logic
    if (!leadCaptured) {

        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const query = document.getElementById('message').value.trim();
        const ip_address = ''; 
        const current_page_url = window.location.href;

               // Validation rules
        const isValidName = /^[a-zA-Z\s]+$/.test(name);
        const isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        const isValidPhone = /^[+]?[0-9]{7,15}$/.test(phone);

        // Validate lead information
        if (name === '' || email === '' || phone === '') {
            alert('Please fill all fields.');
            return; // Stop execution if fields are empty
        }

        if (!isValidName) {
            alert('Please enter a valid name (letters and spaces only).');
            return; // Stop execution if name is invalid
        }

        if (!isValidEmail) {
            alert('Please enter a valid email address.');
            return; // Stop execution if email is invalid
        }

        if (!isValidPhone) {
            alert('Please enter a valid phone number (digits only, with an optional "+" for country code).');
            return; // Stop execution if phone number is invalid
        }
		
 localStorage.setItem('lead_name', name);
        localStorage.setItem('lead_email', email);
        localStorage.setItem('lead_phone', phone);
        // AJAX request to save the lead entry
        const leadData = {
            name: name,
            email: email,
            phone: phone,
            query: query,
            ip_address: ip_address,
            current_page_url: current_page_url,
			lead_id: lead_id
        };
chatSec.style.display = "flex";
				chatHeaderName.style.display = "block";
				chatHeaderBack.style.display= "none";
				buttonStartDiv.style.display = 'none';
                leadCaptureFields.style.display = 'none';
				leadHeader.style.display= "none";
				formOuter.classList.remove("form-outer");
				buttonDiv.classList.remove("button-div");
				msgInput.classList.add("msg-input-lead-filled")
				chatShowDiv.classList.remove("lead-form-open")
		        chatShowDiv.classList.add("lead-form-submit")
				startupBtnsDiv = document.querySelector(".startup-btns")
                startupBtnsDiv.style.display = "flex";
        fetch('/wp-admin/admin-ajax.php?action=save_bot_entry', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(leadData),
        })
		
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Lead captured and saved successfully:', data);
				
                leadCaptured = true;
                message = query;
                console.log('Message after lead capture:', message);
	
                submitMessage(message);
            } else {
                console.error('Failed to save lead entry:', data);
                alert('An error occurred while saving your information. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error during AJAX request:', error);
            alert('An error occurred. Please check your network connection and try again.');
        });

    } else {
        message = userMessage !== undefined ? userMessage : document.getElementById('message').value.trim();
        console.log('Message after lead already captured:', message);
        submitMessage(message);
    }
}

function submitMessage(message) {
    // Check if the message is valid
    if (!message || message.trim() === '') {
        console.warn("Message is empty, null, or undefined:", message);
        return; // Stop execution if the message is not valid
    }

    console.log("Message being sent to API:", message);

    // Prepare content and transcript for submission
    content.push({
        role: 'user',
        parts: {
            text: message
        },
    });

    let timestamp = new Date().toLocaleString();
    conversationTranscript.push({
        sender: 'user',
        time: timestamp,
        parts: {
            text: message
        },
    });
    
    data = "";

    lwhOpenCbotaddMessage('user', message);
    document.getElementById('message').value = ''; // Clear message input
    lwhOpenCbotaddTypingAnimation('ai');
    lwhOpenCbotfetchData();
}

function lwhOpenCbotaddMessage(sender, message) {
    let chatMessagesContainer = document.querySelector('.lwh-open-cbot .chat__messages');
    let messageContainer = document.createElement('div');
    messageContainer.classList.add('chat__messages__' + sender);
    let messageDiv = document.createElement('div');
    messageDiv.innerHTML = `
            ${sender === 'ai' ?
            `
                <div>
                <img width="30px" class="bot-image"
                    src="${botConfigData.botImageURL}"
                    alt="bot-image">
                </div>
                `
            : ""
        }
            <p>${message}
             </p>
            ${sender === 'user' ?
            `
                <div>
                <img width="30px" class="avatar-image"
                    src="${botConfigData.userAvatarURL}"
                    alt="avatar">
                </div>
                `
            : ""
        }
        `;
    messageContainer.appendChild(messageDiv);
    chatMessagesContainer.appendChild(messageContainer);
    chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
}

function lwhOpenCbotaddTypingAnimation(sender) {
    let chatMessagesContainer = document.querySelector('.lwh-open-cbot .chat__messages');
    let typingContainer = document.createElement('div');
    typingContainer.classList.add('chat__messages__' + sender);
    let typingAnimationDiv = document.createElement('div');
    typingAnimationDiv.classList.add('typing-animation');
    typingAnimationDiv.innerHTML = `
        <div>
        <img width="30px" class="bot-image"
            src="${botConfigData.botImageURL}"
            alt="">
        </div>
  <p>
  <svg height="16" width="40" style="max-height: 20px;">
    <circle class="dot" cx="10" cy="8" r="3" style="fill:grey;" />
    <circle class="dot" cx="20" cy="8" r="3" style="fill:grey;" />
    <circle class="dot" cx="30" cy="8" r="3" style="fill:grey;" />
  </svg>
</p>
  `;
    typingContainer.appendChild(typingAnimationDiv);
    chatMessagesContainer.appendChild(typingContainer);
    chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
}

function lwhOpenCbotreplaceTypingAnimationWithMessage(sender, message) {
    let chatMessagesContainer = document.querySelector('.lwh-open-cbot .chat__messages');
    let typingContainer = document.querySelector('.lwh-open-cbot .chat__messages__' + sender + ':last-child');
    if (typingContainer) {
        let messageContainer = document.createElement('div');
        messageContainer.classList.add('chat__messages__' + sender);
        messageContainer.classList.add('chat_messages_ai');
        let messageDiv = document.createElement('div');
        messageDiv.innerHTML = `
                ${sender === 'ai' ?
                `
                    <div>
                    <img width="30px" class="bot-image"
                        src="${botConfigData.botImageURL}"
                        alt="bot-image">
                    </div>
                    `
                : ""
            }
                <p class="typing-effect"></p>
                ${sender === 'user' ?
                `
                    <div>
                    <img width="30px" class="avatar-image"
                        src="${botConfigData.userAvatarURL}"
                        alt="avatar">
                    </div>
                    `
                : ""
            }
            `;
        messageContainer.appendChild(messageDiv);
        typingContainer.parentNode.replaceChild(messageContainer, typingContainer);
        const typingEffectElement = messageDiv.querySelector(".typing-effect");
        let index = 0;
        const typingInterval = setInterval(() => {
            typingEffectElement.textContent += message[index];
            index++;
            if (index === message.length) {
                clearInterval(typingInterval);
                typingEffectElement.insertAdjacentHTML('beforeend', `<span title="copy" class="copy-text" onclick="lwhOpenCbotcopyText(event)"><i class="fa-regular fa-copy"></i><span>copied</span></span>`);
                chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
            }
        }, 5);
        chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
    }
}

function lwhOpenCbotremoveTypingAnimation() {
    let typingAnimationDivs = document.querySelectorAll('.lwh-open-cbot .typing-animation');
    typingAnimationDivs.forEach(function (typingAnimationDiv) {
        let chatMessagesAiDiv = typingAnimationDiv.closest('.chat__messages__ai');
        if (chatMessagesAiDiv) {
            chatMessagesAiDiv.parentNode.removeChild(chatMessagesAiDiv);
        }
    });
}

copyButtons.forEach(button => {
    button.addEventListener('click', function (event) {
        const codeElement = this.parentNode.nextElementSibling.querySelector('code');
        const codeText = codeElement.textContent;
        navigator.clipboard.writeText(codeText).then(function () {
            event.target.innerText = "Copied";
            setTimeout(() => {
                event.target.innerText = "Copy";
            }, 2000);
        }).catch(function (error) {
            console.error('Error copying code: ', error);
        });
    });
});

function lwhOpenCbotcopyText(event) {
    const paragraph = event.target.closest('p');
    const clone = paragraph.cloneNode(true);
    clone.querySelectorAll('.copy-text').forEach(elem => {
        elem.parentNode.removeChild(elem);
    });
    const textToCopy = clone.textContent.trim();
    navigator.clipboard.writeText(textToCopy)
        .then(() => {
            const copiedSpan = event.target.nextElementSibling;
            copiedSpan.style.display = 'block';
            setTimeout(() => {
                copiedSpan.style.display = 'none';
            }, 2000);
        })
        .catch(error => {
            console.error('Error copying text: ', error);
        });
}

async function lwhOpenCbotfetchData() {
    button.disabled = true;
    try {
        response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
         body: JSON.stringify({
    last_prompt: content[content.length - 1].parts.text,
    conversation_history: content,
			 lead_id: lead_id
})
        });

        const data = await response.json();
console.log(data);

        if (data.success) {
            lwhOpenCbotremoveTypingAnimation(); // Remove the typing animation
            lwhOpenCbotaddMessage('ai', data.result);
			    content.push({
                role: 'model',
                parts: {
                    text: data.result  // Add the bot response to the history
                }
            });
        } else {
    console.error('Error:', data.message);
			     lwhOpenCbotremoveTypingAnimation(); // Remove the typing animation
            lwhOpenCbotaddMessage('ai', data.result);
			    content.push({
                role: 'model',
                parts: {
                    text: "Techincal Issue, Please Try again"  // Add the bot response to the history
                }
            });
        }
    } catch (error) {
        console.error('Fetch error:', error);
    } finally {
        button.disabled = false;
    }
}
function insertButtonText(buttonText) {
    const inputField = document.querySelector(".msg-input #message");
    inputField.value = "";
    inputField.value = buttonText;
}

async function lwhOpenCbotfetchBotConfiguration() {
    const chatMessagesContainer = document.querySelector(".lwh-open-cbot .chat__messages");
    document.querySelector(".lwh-open-cbot .loading").style.display = 'flex';
    chatMessagesContainer.innerHTML = '';
    let startupBtnsDiv = document.createElement('div');
    startupBtnsDiv.classList.add('startup-btns');
    chatMessagesContainer.after(startupBtnsDiv);
    let botResponse = ''
    try {
        botResponse = await fetch(botConfigurationUrl);
        if (botResponse.ok) {
            botConfigData = await botResponse.json();
            console.log(botConfigData, "Data from api");
            chatMessagesContainer.style.fontSize = `${botConfigData.fontSize}px`;
            let startupBtns=''
            const startupBtnContainer = document.querySelector('.lwh-open-cbot .startup-btns');
            botConfigData.commonButtons.forEach(btn => {
             startupBtns += `<p onclick="lwhOpenCbotonFormSubmit(event, '${btn.buttonPrompt}'); lwhOpenCbothandleStartupBtnClick(event);">${btn.buttonText}</p>`;
//            startupBtns += `<p onclick="insertButtonText('${btn.buttonText}');">${btn.buttonText}</p>`;

            });            
            startupBtnContainer.innerHTML = startupBtns;
            if (botConfigData.botStatus == 1) {
                document.querySelector(".lwh-open-cbot .chat__status").innerHTML = `<span></span> Online`;
                document.querySelector(".lwh-open-cbot .chat__status").querySelector("span").style.background = "#68D391";
            }
			if (botConfigData.botStatus == 0) {
                document.querySelector("#submit-btn").disabled = true;
			}
           
            document.querySelector(".lwh-open-cbot .loading").style.display = 'none';
            lwhOpenCbotaddMessage('ai', botConfigData.StartUpMessage);
            content.push({
                role: 'model',
                parts: {
text: botConfigData.StartUpMessage,
            }});
          
        } else {
            document.querySelector(".lwh-open-cbot .loading").style.display = 'none';
            lwhOpenCbotshowPopup('Oops! Something went wrong!', '#991a1a');
            throw new Error("Request failed. Please try again!");
        }
    } catch (error) {
        lwhOpenCbotshowPopup('Oops! Something went wrong!', '#991a1a');
        button.disabled = true
        console.error('There was a problem with the fetch operation:', error);
        return;
    }
}

function lwhOpenCbotshowPopup(val, color) {
    button.disabled = false;
    const popup = document.querySelector('.lwh-open-cbot .popup');
    popup.style.display = 'block';
    popup.style.opacity = 1;
    const innerPopup = popup.querySelector('p');
    innerPopup.innerText = val;
    innerPopup.style.color = color;
    popup.classList.add('popup-animation');
    setTimeout(() => {
        popup.classList.remove('popup-animation');
        popup.style.display = 'none';
        popup.style.opacity = 0;
    }, 3000);
}


function lwhOpenCbothandleStartupBtnClick(event){
    const startupBtnContainer = event.target.parentNode;
    startupBtnContainer.style.display = 'none';
}

lwhOpenCbotfetchBotConfiguration();
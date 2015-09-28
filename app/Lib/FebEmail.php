<?php
/**
 * Feb E-Mail
 *
 * PHP 5
 *
 * Licensed under The MIT License
 *
 * @since         CakePHP(tm) v 2.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('CakeEmail', 'Network/Email');

/**
 * Cake e-mail class.
 *
 * 
 * beforeUse:
 *  in file lib/Cake/Network/Email/CakeEmail.php
 * change:
 * 		if (!empty($this->_attachments)) {
 *			$headers['Content-Type'] = 'multipart/mixed; boundary="' . $this->_boundary . '"';
 *		} elseif ($this->_emailFormat === 'text') {
 *
 * to:
 * 
 * 		if (!empty($this->_attachments)) {
 *			$headers['Content-Type'] = 'multipart/related; boundary="' . $this->_boundary . '"';
 *		} elseif ($this->_emailFormat === 'text') {
 * 
 * usage:
 *       App::uses('FebEmail', 'Lib');
 *       $email = new FebEmail('public');
 *       
 *       $email->viewVars(array('message' => $message, 'email' => $this->data['NewsletterMessage']['email']));
 *       //        $email->helpers(array('Html'));
 *       $email->template('user_newsletter')
 *           ->emailFormat(empty($message['NewsletterMessage']['html_content'])?'text':'both')
 *           ->to($this->data['NewsletterMessage']['email'])
 *           ->from(array($message['NewsletterMessage']['sender_email'] => $message['NewsletterMessage']['sender_name']))
 *           ->subject($message['NewsletterMessage']['title']);
 *       $email_sent = $email->send();
 *       //        debug($email_sent); exit;
 * 
 * This class is used for handling Internet Message Format based
 * based on the standard outlined in http://www.rfc-editor.org/rfc/rfc2822.txt
 *
 * @package       Cake.Network.Email
 */
class FebEmail extends CakeEmail {
    
/**
 * Set default embedding method based on <img> tag content 
 *
 * Supported values:
 * - boolean true - embed all images except containing $noembed_class class
 * - boolean false - embed only images containing $embed_class class
 * - null - default embed all images with relative path + images containing $embed_class
 *  
 * @var boolean
 * @access public
 */
	var $embed_images = null;

/**
 * All html images with this class are automaticaly embedded in email
 *  
 * @var string
 * @access public
 */
	var $embed_class = 'embed';

/**
 * All html images with this class are prevented from automatic embedding in email
 *  
 * @var string
 * @access public
 */
	var $noembed_class = 'no_embed';

/**
 * Attach files by adding file contents inside boundaries.
 *
 * @return void
 */
	protected function _attachInlineFiles() {
        $attachments = $this->attachmentsFromContent($this->_message);
        $this->addAttachments($attachments);
        return parent::_attachInlineFiles();
	}
	
	
	
/**
 * Render the body of the email.
 *
 * @param string $content Content to render
 * @return array Email body ready to be sent
 */
	protected function _render($content) {
		$content = implode("\n", $content);
		$rendered = $this->_renderTemplates($content);

		$msg = array();

		$contentIds = array_filter((array)Set::classicExtract($this->_attachments, '{s}.contentId'));
		$hasInlineAttachments = count($contentIds) > 0;
		$hasAttachments = !empty($this->_attachments);
		$hasMultipleTypes = count($rendered) > 1;

		$boundary = $relBoundary = $textBoundary = $this->_boundary;

		if ($hasInlineAttachments) {
			$msg[] = '--' . $boundary;
			$msg[] = 'Content-Type: multipart/related; boundary="rel-' . $boundary . '"';
			$msg[] = '';
			$relBoundary = 'rel-' . $boundary;
		}

		if ($hasMultipleTypes) {
			$msg[] = '--' . $relBoundary;
			$msg[] = 'Content-Type: multipart/alternative; boundary="alt-' . $boundary . '"';
			$msg[] = '';
			$textBoundary = 'alt-' . $boundary;
		}

		if (isset($rendered['text'])) {
			if ($textBoundary !== $boundary || $hasAttachments) {
				$msg[] = '--' . $textBoundary;
				$msg[] = 'Content-Type: text/plain; charset=' . $this->charset;
				$msg[] = 'Content-Transfer-Encoding: ' . $this->_getContentTransferEncoding();
				$msg[] = '';
			}
			$this->_textMessage = $rendered['text'];
			$content = explode("\n", $this->_textMessage);
			$msg = array_merge($msg, $content);
			$msg[] = '';
		}
	
		if (isset($rendered['html'])) {
			if ($textBoundary !== $boundary || $hasAttachments) {
				$msg[] = '--' . $textBoundary;
				$msg[] = 'Content-Type: text/html; charset=' . $this->charset;
				$msg[] = 'Content-Transfer-Encoding: ' . $this->_getContentTransferEncoding();
				$msg[] = '';
			}
			$this->_htmlMessage = $rendered['html'];
			$content = explode("\n", $this->_htmlMessage);
			$msg = array_merge($msg, $content);
			$msg[] = '';
		}

		if ($hasMultipleTypes) {
			$msg[] = '--' . $textBoundary . '--';
			$msg[] = '';
		}

		if ($hasInlineAttachments) {
    		$boundary = $this->_boundary;
    		$this->_boundary = $relBoundary;
			$attachments = $this->_attachInlineFiles();
    		$this->_boundary = $boundary;
			$msg = array_merge($msg, $attachments);
			$msg[] = '';
			$msg[] = '--' . $relBoundary . '--';
			$msg[] = '';
		}

		if ($hasAttachments) {
			$attachments = $this->_attachFiles();
			$msg = array_merge($msg, $attachments);
		}
		if ($hasAttachments || $hasMultipleTypes) {
			$msg[] = '';
			$msg[] = '--' . $boundary . '--';
			$msg[] = '';
		}
		return $msg;
	}
	
    
    
/**
 *  function returns attachments array for CakeEmail Class
 * 
 * @param string $content is searched against img tags and has replaced src params with CIDs 
 * 
 *  CakeEmail::attachments($attachmentsArray);
 * 
 * @return attachments array for CakeEmail Class
 */    
    function attachmentsFromContent(&$content){

		$matches = array();
        
        if(is_array($content)){
            $temp_content = $content;
        } else {
            $temp_content = array($content);
        }
		
        foreach($temp_content AS $key => $line){

            preg_match_all('/<img[^>]+(?:class="([^"]+)"[^>]+|)src="([^"]+)"[^>]+(?:class="([^"]+)"[^>]+|)>/Uus', $line, $matches[$key]);
            if(empty($matches[$key][0])){
                unSet($matches[$key]);
            }
        }

        $attachments = array();

        foreach($matches AS $key => $img){
            $image_size = null;
            $is_url = false;
            $path = '';
            $class = null;
            $classes = array();

            if(strpos($img[2][0], 'http://') === 0 or strpos($img[2][0], 'https://') === 0){
                $is_url = true;
                $path = $img[2][0];
            } else {
                $path = WWW_ROOT.$img[2][0];
            }
            
            if(!empty($img[3][0])){
                $classes = explode(' ', $img[3][0]);
            } elseif(!empty($img[1][0])){
                $classes = explode(' ', $img[1][0]);
            }
            
            if(in_array($this->embed_class, $classes)){
                $class = true;
            } elseif(in_array($this->noembed_class, $classes)) {
                $class = false;
            }

    		switch(true){
                case ($this->embed_images === true AND $class !== false):
                case ($this->embed_images === false AND $class === true):
                case ($this->embed_images === null AND (!$is_url OR $class === true)):
                
                $image_size = @getimagesize($path);
                if(!empty($image_size)){

                    if(empty($attachments[$img[2][0]])){
                        $attachments[$img[2][0]] = array(
                            'file' => $path,
                            'contentId' => md5($img[2][0]),
                        );
                        if(!empty($image_size['mime'])){
                            $attachments[$img[2][0]]['mimetype'] = $image_size['mime'];
                        }
                    }

                    $temp_content[$key] = str_replace($img[2][0], 'cid:'.$attachments[$img[2][0]]['contentId'], $temp_content[$key]);

                }
            }

        }

        foreach($attachments AS $key => $attachment){
            $this->attachments[basename($key)] = $attachment;
        }
        
        if(is_array($content)){
            $content = $temp_content;
        } else {
            $content = $content[0];
        }
        
        return $attachments;
    } 
    
    

}

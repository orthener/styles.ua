<?php

App::import('Component', 'Email');

class FebEmailComponent extends EmailComponent {

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
     * @var $config string default value is 'Default'. 
     * Use Configure::write('Email.Default.to', 'example@example.com'); in bootstrap to set default recipient
     * Another conf 'Admin':  Configure::write('Email.Admin.to', 'myname@mydomain.com');
     */
    var $config = 'Default';

    /**
     * Set empty params to default values
     *  
     * @param $reset boolean if set to true all params will be overwritten with its default values
     * @return void
     * @access public
     */
    function setParams($reset = false) {

        $fields = array(
            'to' => null, 'from' => null, 'replyTo' => null, 'cc' => array(), 'bcc' => array(),
            'subject' => null, 'layout' => 'default', 'template' => null, 'sendAs' => 'text',
            'delivery' => 'mail', 'charset' => 'utf-8', 'xMailer' => 'CakePHP Email Component',
        );

        foreach ($fields AS $field => $default) {
            if (empty($this->$field) or $reset) {
                $value = Configure::read('Email.' . $this->config . '.' . $field);
                if (empty($value)) {
                    $value = $default;
                }
                $this->$field = $value;
            }
        }
    }

    /**
     * Send an email using the specified content, template and layout
     *
     * @param mixed $content Either an array of text lines, or a string with contents
     * @param string $template Template to use when sending email
     * @param string $layout Layout to use to enclose email body
     * @return boolean Success
     * @access public
     */
    function send($content = null, $template = null, $layout = null) {

        $this->setParams();
        return parent::send($content, $template, $layout);
    }

    /**
     * Create emails headers including (but not limited to) from email address, reply to,
     * bcc and cc.
     *
     * @access private
     */
    function _createHeader() {

        $this->attachments[] = null;

        parent::_createHeader();

//         $default_ctt = 'multipart/mixed; boundary="' . $this->__boundary . '"';
//         if(($i = array_search('Content-Type: '.$default_ctt, $this->__header)) === false){
//             return;
//         }
//         
//         $this->__header[$i] = str_replace('multipart/mixed', 'multipart/related', $this->__header[$i]);

        $this->__header = str_replace('multipart/mixed', 'multipart/related', $this->__header);
    }

    /**
     * Attach files by adding file contents inside boundaries.
     *
     * @access private
     * @TODO: modify to use the core File class?
     */
    function _imagesFromContent() {

        $matches = array();

        foreach ($this->__message AS $key => $line) {

            preg_match_all('/<img[^>]+(?:class="([^"]+)"[^>]+|)src="([^"]+)"[^>]+(?:class="([^"]+)"[^>]+|)>/Uus', $line, $matches[$key]);
            if (empty($matches[$key][0])) {
                unSet($matches[$key]);
            }
        }

        $attachments = array();

        foreach ($matches AS $key => $img) {
            $image_size = null;
            $is_url = false;
            $path = '';
            $class = null;
            $classes = array();

            if (strpos($img[2][0], 'http://') === 0 or strpos($img[2][0], 'https://') === 0) {
                $is_url = true;
                $path = $img[2][0];
            } else {
                $path = WWW_ROOT . $img[2][0];
            }

            if (!empty($img[3][0])) {
                $classes = explode(' ', $img[3][0]);
            } elseif (!empty($img[1][0])) {
                $classes = explode(' ', $img[1][0]);
            }

            if (in_array($this->embed_class, $classes)) {
                $class = true;
            } elseif (in_array($this->noembed_class, $classes)) {
                $class = false;
            }

            switch (true) {
                case ($this->embed_images === true AND $class !== false):
                case ($this->embed_images === false AND $class === true):
                case ($this->embed_images === null AND (!$is_url OR $class === true)):

                    $image_size = @getimagesize($path);
                    if (!empty($image_size)) {

                        if (empty($attachments[$img[2][0]])) {
                            $attachments[$img[2][0]] = array(
                                'filename' => $path,
                                'mimetype' => $image_size['mime'],
                                'cid' => md5($img[2][0]),
                            );
                        }

                        $this->__message[$key] = str_replace($img[2][0], 'cid:' . $attachments[$img[2][0]]['cid'], $this->__message[$key]);
                    }
            }
        }

        foreach ($attachments AS $key => $attachment) {
            $this->attachments[basename($key)] = $attachment;
        }
    }

    /**
     * Attach files by adding file contents inside boundaries.
     *
     * @access private
     * @TODO: modify to use the core File class?
     */
    function _attachFiles() {
        $files = array();
        $mimetypes = array();
        $cids = array();

        //ustawienie pobrania obrazków na podstawie treści <img src="..." />
        $this->_imagesFromContent();

        foreach ($this->attachments as $filename => $attachment) {

            ///////////////
            /// diff 1{ ///
            if (is_array($attachment)) {
                $mimetype = $attachment['mimetype'];
                $cid = $attachment['cid'];
                $attachment = $attachment['filename'];
            } elseif ($attachment != null) {
                $mimetype = 'application/octet-stream';
                $cid = false;
            } else {
                continue;
            }
            /// }diff 1 ///
            ///////////////

            $file = $this->_findFiles($attachment);
            if (!empty($file)) {
                if (is_int($filename)) {
                    $filename = basename($file);
                }
                $files[$filename] = $file;

                ///////////////
                /// diff 2{ ///
                $mimetypes[$filename] = $mimetype;
                $cids[$filename] = $cid;
                /// }diff 2 ///
                ///////////////
            }
        }

        foreach ($files as $filename => $file) {
            $handle = fopen($file, 'rb');
            $data = fread($handle, filesize($file));
            $data = chunk_split(base64_encode($data));
            fclose($handle);

            $this->__message[] = '--' . $this->__boundary;
//			$this->__message[] = 'Content-Type: application/octet-stream';
            $this->__message[] = 'Content-Type: ' . $mimetypes[$filename];
            $this->__message[] = 'Content-Transfer-Encoding: base64';
// 			$this->__message[] = 'Content-Disposition: attachment; filename="' . basename($filename) . '"';
            if ($cids[$filename] != '') {
                $this->__message[] = 'Content-ID: <' . $cids[$filename] . '>';
                $this->__message[] = 'Content-Disposition: inline; filename="' . $filename . '"';
            } else {
                $this->__message[] = 'Content-Disposition: attachment; filename="' . $filename . '"';
            }
            $this->__message[] = '';
            $this->__message[] = $data;
            $this->__message[] = '';
        }
    }

}

?>
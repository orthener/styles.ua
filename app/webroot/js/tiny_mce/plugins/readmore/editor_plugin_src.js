/**
 * editor_plugin_src.js
 *
 * Copyright 2011, Fabryka e-biznesu sp z o.o.
 * Released under LGPL License.
 * Based on: pagebreak plugin (Moxiecode Systems AB) 
 *
 * License: http://www.gnu.org/licenses/lgpl-2.1.html
 * Author: arek@dziki.eu
 *  
 */

(function() {
	tinymce.create('tinymce.plugins.ReadMorePlugin', {
		init : function(ed, url) {
			var pb = '<img src="' + url + '/img/trans.gif" class="mceReadMore mceItemNoResize" />', cls = 'mceReadMore', sep = ed.getParam('readmore_separator', '<!-- readmore -->'), pbRE;

			pbRE = new RegExp(sep.replace(/[\?\.\*\[\]\(\)\{\}\+\^\$\:]/g, function(a) {return '\\' + a;}), 'g');

			// Register commands
			ed.addCommand('mceReadMore', function() {
				ed.execCommand('mceInsertContent', 0, pb);
			});

			// Register buttons
			ed.addButton('readmore', {title : 'readmore.desc', cmd : cls});

			ed.onInit.add(function() {
				if (ed.settings.content_css !== false)
					ed.dom.loadCSS(url + "/css/content.css");

				if (ed.theme.onResolveName) {
					ed.theme.onResolveName.add(function(th, o) {
						if (o.node.nodeName == 'IMG' && ed.dom.hasClass(o.node, cls))
							o.name = 'readmore';
					});
				}
			});

			ed.onClick.add(function(ed, e) {
				e = e.target;

				if (e.nodeName === 'IMG' && ed.dom.hasClass(e, cls))
					ed.selection.select(e);
			});

			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('readmore', n.nodeName === 'IMG' && ed.dom.hasClass(n, cls));
			});

			ed.onBeforeSetContent.add(function(ed, o) {
				o.content = o.content.replace(pbRE, pb);
			});

			ed.onPostProcess.add(function(ed, o) {
				if (o.get)
					o.content = o.content.replace(/<img[^>]+>/g, function(im) {
						if (im.indexOf('class="mceReadMore') !== -1)
							im = sep;

						return im;
					});
			});
		},

		getInfo : function() {
			return {
				longname : 'ReadMore',
				author : 'Fabryka e-biznezu sp. z o.o.',
				authorurl : 'http://feb.net.pl',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/pagebreak',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('readmore', tinymce.plugins.ReadMorePlugin);
})();
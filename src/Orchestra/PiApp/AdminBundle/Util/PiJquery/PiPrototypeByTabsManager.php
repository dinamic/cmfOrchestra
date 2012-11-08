<?php
/**
 * This file is part of the <Admin> project.
 *
 * @category   Admin_Util
 * @package    Extension_jquery 
 * @author (c) <etienne de Longeaux> <etienne.delongeaux@gmail.com>
 * @since 2012-01-11
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PiApp\AdminBundle\Util\PiJquery;

use Symfony\Component\DependencyInjection\ContainerInterface;

use PiApp\AdminBundle\Twig\Extension\PiJqueryExtension;
use PiApp\AdminBundle\Exception\ExtensionException;

/**
 * MultiSelect Jquery plugin
 *
 * @category   Admin_Util
 * @package    Extension_jquery 
 * 
 * @author (c) <etienne de Longeaux> <etienne.delongeaux@gmail.com>
 */
class PiPrototypeByTabsManager extends PiJqueryExtension
{
	/**
	 * Constructor.
	 *
	 * @param ContainerInterface $container The service container
	 */
	public function __construct(ContainerInterface $container)
	{
		parent::__construct($container);
	}
	
	/**
	 * Sets init.
	 *
	 * @access protected
	 * @return void
	 *
	 * @author Etienne de Longeaux <etienne_delongeaux@hotmail.com>
	 */	
	protected function init() {
		
		// radio and checkbox managment
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addCssFile("bundles/piappadmin/css/themes/wijmo/jquery.wijmo.wijsuperpanel.css");
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addCssFile("bundles/piappadmin/css/themes/wijmo/jquery.wijmo.wijradio.css");
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addCssFile("bundles/piappadmin/css/themes/wijmo/jquery.wijmo.wijcheckbox.css");
		
		// tabs managment
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addCssFile("bundles/piappadmin/css/themes/wijmo/jquery.wijmo.wijdialog.css");
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addCssFile("bundles/piappadmin/css/themes/wijmo/jquery.wijmo.wijtabs.css");

		// simple and multiselect managment
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addCssFile("bundles/piappadmin/js/jquery/multiselect/css/jquery.multiselect.filter.css");
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addCssFile("bundles/piappadmin/js/jquery/multiselect/css/jquery.multiselect.css");
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addJsFile("bundles/piappadmin/js/jquery/multiselect/js/jquery.multiselect.filter.min.js");
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addJsFile("bundles/piappadmin/js/jquery/multiselect/js/jquery.multiselect.min.js");
		
		// multi-select chained management
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addJsFile("bundles/piappadmin/js/jquery/jquery.chained.remote.js");
		
		// dates managment
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addCssFile("bundles/piappadmin/css/themes/wijmo/jquery.wijmo.wijinput.css");
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addJsFile("bundles/piappadmin/js/wijmo/minified/jquery.wijmo.wijcalendar.min.js");
		//$this->container->get('pi_app_admin.twig.extension.layouthead')->addJsFile("bundles/piappadmin/js/wijmo/minified/jquery.wijmo.wijinputdate.min.js");
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addJsFile("bundles/piappadmin/js/wijmo/minified/jquery.wijmo.wijinputcore.min.js");
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addJsFile("bundles/piappadmin/js/wijmo/minified/jquery.plugin.wijtextselection.min.js");
		
		// editor managment
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addJsFile("bundles/piappadmin/js/tiny_mce/jquery.tinymce.js");
		
		// main
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addJsFile("bundles/piappadmin/js/wijmo/external/cultures/globalize.cultures.js");
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addJsFile("bundles/piappadmin/js/wijmo/external/globalize.min.js");
		//$this->container->get('pi_app_admin.twig.extension.layouthead')->addJsFile("bundles/piappadmin/js/wijmo/external/jquery.mousewheel.min.js");
		
		// theme form + wijmo rocket
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addCssFile('bundles/piappadmin/css/form/form.css');
		
		// wijmo
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addCssFile("bundles/piappadmin/css/themes/wijmo/jquery.wijmo-open.2.1.2.css");
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addCssFile("bundles/piappadmin/css/themes/rocket/jquery-wijmo.css");
		$this->container->get('pi_app_admin.twig.extension.layouthead')->addJsFile("bundles/piappadmin/js/wijmo/external/jquery.wijmo-complete.all.2.1.2.min.js");
		
	}	
	
    /**
      * Sets render for prototype links in the form.
      *
      * @param	$options	tableau d'options.
      * @access protected
      * @return void
      *
      * @author Etienne de Longeaux <etienne_delongeaux@hotmail.com> 
      */
	protected function render($options = null)
	{        
		// Option management
		if(!isset($options['prototype-name']) || empty($options['prototype-name']))
			throw ExtensionException::optionValueNotSpecified('prototype-name', __CLASS__);

		if(!isset($options['prototype-tab-title']) || empty($options['prototype-tab-title']))
			throw ExtensionException::optionValueNotSpecified('prototype-tab-title', __CLASS__);
		
		if(!isset($options['prototype-tab-idForm']) || empty($options['prototype-tab-idForm']))
			$options['prototype-idForm'] = ".myform";
		
	    // We open the buffer.
	    ob_start ();		
		?>
			<div class="demo-options">
				<!-- Begin options markup -->
				<div id="dialog" title="<?php echo $this->translator->trans('pi.form.tab.box.title'); ?>">
					<fieldset class="ui-helper-reset">
						<label>
							<?php echo $this->translator->trans('pi.form.tab.box.click'); ?>
						</label>
					</fieldset>
				</div>
				<!-- End options markup -->
			</div>	
			
			<div id="form-error-dialog" >&nbsp;</div>
			
			<script type="text/javascript">
			//<![CDATA[
			
				// we create the animations.
				var j_prototype_bytabs = new function()
				{
					var tab_counter 		= 2;
					var name_prototype 		= '';
				    var $prototype_content 	= '';
				    var name_idForm			= '';

					// tabs init with a custom tab template and an "add" callback filling in the content
					var $tabs = $('#tabs').wijtabs({
						tabTemplate: '<li><a href="#{href}">#{label}</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>',
						add: function (event, ui) {
							// On enregistre le contenu du prototype dans le nouveau tab.
							$(ui.panel).append('<p>' + $prototype_content + '</p>');
						},
						select: function (event, ui) { 
							//$(".pi_simpleselect").delay(2000).data("wijdropdown").refresh();
							 //$(".pi_simpleselect").wijdropdown();
						}
					});
	
					// modal dialog init: custom buttons and a "close" callback reseting the form inside
					var $dialog = $('#dialog').wijdialog({
						showStatus: false,
						showControlBox: false,
						autoOpen: false,
						modal: true,
						buttons: {
							'<?php echo $this->translator->trans('pi.form.tab.box.add'); ?>': function () {
								j_prototype_bytabs.ftc_add_tag();
								$(this).wijdialog('close');
							},
							'<?php echo $this->translator->trans('pi.form.tab.box.cancel'); ?>': function () {
								$(this).wijdialog('close');
							}
						},
						open: function () {
						},
						close: function () {
						}
					});				
	
					// We inject the error messages via a dialog
					var value_message = '';

					$(".symfony-form-errors").each(function(index) {
						value_message = value_message + $(this).html();
					});
					
					this.ftc_init = function(idForm, var_prototype){
												// We initialize the variables.
												name_prototype = var_prototype;
												name_idForm	   = idForm;

												if(value_message.length != 0) {
													// modal dialog for the error form
													$('#form-error-dialog').wijdialog({
										                autoOpen: true,
										                height: 300,
										                width: 400,
										                modal: true,
										                buttons: {
										                    Ok: function () {
										                        $(this).wijdialog("close");
										                    }
										                },
										                open: function () {
										                	$(this).attr('title', 'Error form');
										                	$(this).html(value_message);
														},
										                captionButtons: {
										                    pin: { visible: false },
										                    refresh: { visible: false },
										                    toggle: { visible: false },
										                    minimize: { visible: false },
										                    maximize: { visible: false }
										                }
										            });
										        }					
										        	
												// Tags with onglet management
												$("#tabs").wijtabs({ 
													scrollable: true,
													alignment: 'top',
													showOption: {
									                    blind: false,
									                    fade: true,
									                    duration: 400,
									                },
									                hideOption: {
									                    blind: false,
									                    fade: true,
									                    duration: 200,
									                }
												});
									
												// addTab form: calls addTab function on submit and closes the dialog
												$('fieldset', $dialog).submit(function () {
													j_prototype_bytabs.ftc_addTab();
													$dialog.wijdialog('close');
													return false;
												});
												
												// addTab button: just opens the dialog
												$('#add_tab').button()
															.click(function () {
																$dialog.wijdialog('open');
															});
									
												// close icon: removing the tab on click
												// note: closable tabs gonna be an option in the future - see http://dev.jqueryui.com/ticket/3924
												$('#tabs span.ui-icon-close').live('click', function () {
													var index = $('li', $tabs).index($(this).parent());
													$tabs.wijtabs('remove', index);
												});	
	
												// We run the "get start" of construction.
												j_prototype_bytabs.ftc_addGetStart(name_idForm);

												
					};
		
					// actual addTab function: adds new tab using the title input from the form above
					this.ftc_addGetStart = function(idForm){
												$("div[id^='"+name_prototype+"_']").each(function(index) {
													// It retrieves the content.
													var $dataprototype = $(this).html();
													
													// We tag the prototype with the corresponding class.
													$prototype_content = '<fieldset class="no-accordion"><div id="'+name_prototype+'_' + index + '" >' + $dataprototype + '</div></fieldset>';
													
													// We add the contents into a new tab.
													j_prototype_bytabs.ftc_addTab(index+1);
												});
												
												// It deletes the contents of all collections of such translation.
												$("#prototype_all_widgets_"+name_prototype).remove();

												// Applying the widgets plugin "wijmo" on the new collection.
									    		j_prototype_bytabs.ftc_add_render_form(idForm);
												
					};
					
				    // We define a function that will add a field.
				    this.ftc_add_tag = function(){
												var index	= $("div[id^='"+name_prototype+"_']").length;

										        // On récupère la balise <script> en question qui contient le contenu « data-prototype ».
										        var $prototype     = $('script#prototype_script_'+name_prototype);

										        // On remplace la variable $$name$$ qu'il contient par le numéro du champ.
										        var $dataprototype = $prototype.html().replace(/\$\$name\$\$/g, index);
												
												// On balise le prototype avec la class correspondant
												$prototype_content = '<fieldset><div id="'+name_prototype+'_' + index + '" >' + $dataprototype + '</div></fieldset>';
												
												// On ajoute le contenu dans un nouveau onglet
												j_prototype_bytabs.ftc_addTab(index+1);
												
												// On applique les widget du plugin wijmo sur la nouvelle collection
									    		j_prototype_bytabs.ftc_add_render_form("#"+name_prototype+"_" + index);
				    };
				    
					// actual addTab function: adds new tab using the title input from the form above
					this.ftc_addTab = function(index){
												$tabs.wijtabs('add', '#tabs-' + tab_counter, '<?php echo $options['prototype-tab-title']; ?> ' + index);
												tab_counter++;
					};		    

				    // Applying the widgets.
				    this.ftc_add_render_form = function(prototype_widget){
										        $(prototype_widget + " input[type='radio']").wijradio();
										        $(prototype_widget + " input[type='checkbox']").wijcheckbox();

												$(prototype_widget + " select.pi_simpleselect").multiselect({
												   multiple: false,
												   header: true,
												   noneSelectedText: "<?php echo $this->translator->trans('pi.form.label.select.choose.option'); ?>",
												   selectedList: 1
												}).multiselectfilter();										        

												$(prototype_widget + " select.pi_multiselect").multiselect({
												   multiple: true,
												   header: true,
												   noneSelectedText: "<?php echo $this->translator->trans('pi.form.label.select.choose.options'); ?>",
												   selectedList: 4
												}).multiselectfilter();										        
												
										        $(prototype_widget + " .pi_datepicker").wijinputdate({
								            		showTrigger: true,
								            		culture: '<?php echo str_replace("_", "-", $this->locale); ?>',
								            		//dateFormat: 'MM/dd/yyyy'
										        });

										        $(prototype_widget + " .pi_datetimepicker").wijinputdate({
								            		showTrigger: true,
								            		dateFormat: 'g'
										        });

										        $("[class*='limited']").each(function(i){
												    var c = $(this).attr("class");
												    var from = c.indexOf("(");
												    var to = c.indexOf(")");
												    var limit = parseInt(c.substring(from+1,to));

												    $(this).bind("keyup keydown change",function(e){
												      if (this.value.length > limit) {
												      this.value = this.value.substring(0, limit);
												      }
												    });
												});							        

										        j_prototype_bytabs.ftc_tinymce_editor($(prototype_widget + " .pi_editor"));										        
										        j_prototype_bytabs.ftc_tinymce_editor_simple($(prototype_widget + " .pi_editor_simple"));
										        
										        $("button[type='submit']").button();
										        $("input[type='button']").click(function () { return false; });
			        };	


			        this.ftc_tinymce_editor = function(idObj){
			        	idObj.tinymce({
							// Location of TinyMCE script
							script_url : '//<?php echo $this->container->get('Request')->getHttpHost(); ?><?php echo $this->container->get('Request')->getBasePath(); ?>/bundles/piappadmin/js/tiny_mce/tiny_mce.js',
							// General options
							theme : "advanced",
							language : "<?php echo strtolower(current(explode("_", $this->locale))); ?>",
							plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
							// don't replace encoding character like : Ã© to &eacutes;
							entity_encoding : "raw",
							// Theme options
							theme_advanced_buttons1 : "fullscreen,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
							theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
							theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,advhr,|,print,|,ltr,rtl",
							theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
							theme_advanced_toolbar_location : "top",
							theme_advanced_toolbar_align : "left",
							theme_advanced_statusbar_location : "bottom",
							theme_advanced_resizing : true,

							// Exemple content CSS (should be your site CSS)
							//content_css : "css/content.css",

							// Drop lists for link/image/media/template dialogs
							template_external_list_url : "lists/template_list.js",
							external_link_list_url : "lists/link_list.js",
							external_image_list_url : "lists/image_list.js",
							media_external_list_url : "lists/media_list.js",
							// count without the lenght of html balise
							setup : function(ed) {
                                ed.onKeyUp.add(function(ed, e) {
                                    var strip = (tinymce.activeEditor.getContent()).replace(/(<([^>]+)>)/ig,"").replace(/&[a-z]+;/ig, "");
                                    var text = strip.split(' ').length + " Mots, " +  (10000 - strip.length) + " Caractères "
                                    tinymce.DOM.setHTML(tinymce.DOM.get(tinymce.activeEditor.id + '_path_row'), text);

                                    // limit the lenght of written
                                    //if (strip.length > ("<?php if($this->container->get('Request')->get('_route')== 'gedmo_admin_social_edit'){ ?>"+245+"<?php }else{ ?>"+475+"<?php } ?>")) {
                                    //      strip = strip.substring(0,("<?php if($this->container->get('Request')->get('_route')== 'gedmo_admin_social_edit'){ ?>"+245+"<?php }else{ ?>"+475+"<?php } ?>"));
                                    //      tinymce.execCommand('mceSetContent',false,strip);
                                    //}
                                });
                            }
						});
				    };	

				    this.ftc_tinymce_editor_simple = function(idObj){
			        	idObj.tinymce({
							// Location of TinyMCE script
							script_url : '//<?php echo $this->container->get('Request')->getHttpHost(); ?><?php echo $this->container->get('Request')->getBasePath(); ?>/bundles/piappadmin/js/tiny_mce/tiny_mce.js',
							// General options
							theme : "advanced",
							language : "<?php echo strtolower(current(explode("_", $this->locale))); ?>",
							plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
							// don't replace encoding character like : Ã© to &eacutes;
							entity_encoding : "raw",							
							// Theme options
							theme_advanced_buttons1 : "fullscreen,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,hr,sub,sup,forecolor,backcolor",
							theme_advanced_buttons2 : "code,link,unlink,search,replace,tablecontrols",
							theme_advanced_buttons3 : "",
							theme_advanced_toolbar_location : "top",
							theme_advanced_toolbar_align : "left",
							theme_advanced_statusbar_location : "bottom",
							theme_advanced_resizing : true,

							// Exemple content CSS (should be your site CSS)
							//content_css : "css/content.css",

							// Drop lists for link/image/media/template dialogs
							template_external_list_url : "lists/template_list.js",
							external_link_list_url : "lists/link_list.js",
							external_image_list_url : "lists/image_list.js",
							media_external_list_url : "lists/media_list.js",
							// count without the lenght of html balise
							setup : function(ed) {
                                ed.onKeyUp.add(function(ed, e) {
                                    var strip = (tinymce.activeEditor.getContent()).replace(/(<([^>]+)>)/ig,"").replace(/&[a-z]+;/ig, "");
                                    var text = strip.split(' ').length + " Mots, " +  (10000 - strip.length) + " Caractères "
                                    tinymce.DOM.setHTML(tinymce.DOM.get(tinymce.activeEditor.id + '_path_row'), text);

                                    // limit the lenght of written
                                    //if (strip.length > ("<?php if($this->container->get('Request')->get('_route')== 'gedmo_admin_social_edit'){ ?>"+245+"<?php }else{ ?>"+475+"<?php } ?>")) {
                                    //      strip = strip.substring(0,("<?php if($this->container->get('Request')->get('_route')== 'gedmo_admin_social_edit'){ ?>"+245+"<?php }else{ ?>"+475+"<?php } ?>"));
                                    //      tinymce.execCommand('mceSetContent',false,strip);
                                    //}
                                });
                            }
						});
				    };					    				
					
					// THIS FUNCTION ALLOW TO INJECT SEVERAL FIELDS IN A ACCORDION MENU.
			        this.ftc_accordion_form = function(className, title, idForm){
						/* 
						$(idForm+" fieldset:first").addClass('no-accordion');
						if ( $('.accordion-form').length == 0 ) $("<div class='accordion-form'>").insertAfter(idForm+" fieldset");
						var accordionId = "accordion_"+className;
						$("<fieldset id='"+accordionId+"' class='accordion'><a href='#' class='accordion_link_"+className+"' title='"+title+"'>"+title+"</a></fieldset>").appendTo('.accordion-form');
						
						$("."+className).each(function(index) {
							$(this).parent('.clearfix').detach().appendTo("#"+accordionId);
						});
						*/
						var tabsToProcess = $(idForm+" .ui-tabs-panel");
						
						$(tabsToProcess).each(function(indTab,tabProcessed){
							var tabProcessedId = $(tabProcessed).attr("id");
							
							if ( $("#"+tabProcessedId+" ."+className).length ==0 ) {
								// Process next $.each()
								return;
							}
							
							$("#"+tabProcessedId+" fieldset:first").addClass("no-accordion");
							if ( $("#"+tabProcessedId+" .accordion-form").length == 0 ) {
								$("<div class='accordion-form'>").insertAfter("#"+tabProcessedId+" fieldset");
							}
							
							var accordionId = "accordion_" + tabProcessedId + "_" + className;
							$("<fieldset id='"+accordionId+"' class='accordion'><a href='#' class='accordion_link_"+className+"' title='"+title+"'>"+title+"</a></fieldset>").appendTo("#"+tabProcessedId+" .accordion-form");
							
							$("#"+tabProcessedId+" ."+className).each(function(indClass) {
								$(this).parent('.clearfix').detach().appendTo("#"+accordionId);
							});	
						
							$('#'+accordionId+' a').click(function () {
								var that = $(this);
								var newHeight = function(){
									var h=16;	//initial height when closed
									that.parent('fieldset').children('.clearfix').each(function(ind,el){
										h += $(el).outerHeight(true);
									});
									return (h+80)+'px';
								};
								
								if ( $(this).parent('fieldset').hasClass('open') ){
									$(this).parent('fieldset').removeClass('open');
									$(this).parent('fieldset').animate({
										height: '16px'
									  }, 400, 'swing'
									);
								} else {
									$(this).parent('fieldset').animate({
										height: newHeight()
									  }, 400, 'swing', function() {
										$(this).addClass('open');
									}).siblings('fieldset').removeClass('open').animate({
										height: '16px'
									  }, 400, 'swing'
									);
								}
								return false;
							});
						});
					};
						
						
					
					// this function allow to inject several fields in a dialog.
			        this.ftc_dialog_form = function(className, title, idForm, height, width, position){
						// We inject the testimonial fields via a dialog
						// var button	 = $("<a href='#' style='margin-right:30px' class=' dialog_link_"+className+"' title='"+title+"'>"+title+"</a>").appendTo(idForm+" fieldset"); SBLA
						var button	 = $("<a href='#' style='margin-right:30px' class=' dialog_link_"+className+"' title='"+title+"'>"+title+"</a>");
						$(idForm+" fieldset:first").append(button);
						var form	 = "form_"+className;
						var obj_form = null;
						var dialogId = "dialog_"+className;

						$("<div id='"+dialogId+"' class='dialog_form' ><span id='"+form+"'></span></div>").appendTo(idForm);
					
						$("."+className).each(function(index) {
							$(this).parent().attr('style', "display:none");
						});	

						// modal dialog init: custom buttons and a "close" callback reseting the form inside
						var $dialog_form = $('#'+dialogId).wijdialog({
							zIndex: 99999,
							autoOpen: false,
							modal:true,
							height: height,
				            width: width,
				            position: position,
							buttons: {
								'<?php echo $this->translator->trans('pi.form.tab.box.close'); ?>': function () {
									$(this).wijdialog('close');
								},
							},
							open: function () {
			                	$(this).wijdialog({title: title + ' form'});
							},
							focus: function () {
								//j_prototype_bytabs.ftc_tinymce_editor($(".pi_editor"));
							},
			                beforeClose: function () {
				                obj_form = $(this).children().detach();
				                obj_form.attr('style', "display:none").appendTo(idForm);
							},
			                captionButtons: {
				                    pin: { visible: false },
				                    refresh: { visible: false },
				                    toggle: { visible: true },
				                    minimize: { visible: false },
				                    maximize: { visible: false }
				                },        								
			                show: 'scale',
			                hide: 'scale',				
						});	

						button.click(function () {
							if(obj_form != null){
								obj_form = $("#"+form).detach();
				                obj_form.appendTo($dialog_form);
				                obj_form.attr('style', "display:block");
							}else{
								$("."+className).each(function(index) {
									obj_start = $(this).parent().attr('style', "display:block");
									obj_start.detach().appendTo("#"+form);
									obj_newform = $("#"+form).detach();
									obj_newform.appendTo($dialog_form);
									obj_newform.attr('style', "display:block");
								});	
							}
								
							$dialog_form.wijdialog('open');
						});						
					};

				};

				$(document).ready(function() {
					<?php foreach($options['prototype-name'] as $key => $value){ ?>
					// We run the function.
				    	j_prototype_bytabs.ftc_init('<?php echo $options['prototype-idForm']; ?>', '<?php echo $value; ?>');
				    <?php } ?>
					//jQuery(document).trigger('htmlAppended')	
				});

			//]]>
			</script>  	
		<?php 
		// We retrieve the contents of the buffer.
		$_content = ob_get_contents ();
		// We clean the buffer.
		ob_clean ();
		// We close the buffer.
		ob_end_flush ();
		
		return $_content;
	}
	
}
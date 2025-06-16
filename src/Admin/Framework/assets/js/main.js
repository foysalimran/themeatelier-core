/**
 *
 * -----------------------------------------------------------
 *
 * Codestar Framework
 * A Simple and Lightweight WordPress Option Framework
 *
 * -----------------------------------------------------------
 *
 */
; (function ($, window, document, undefined) {
  'use strict';
  // Preloader script
  $(document).ready(function () {
    $('.themeatelier-core-admin').removeClass('chat-help-preloader');
  });
  //
  // Constants
  //
  var THEMEATELIER_CORE = THEMEATELIER_CORE || {};

  THEMEATELIER_CORE.funcs = {};

  THEMEATELIER_CORE.vars = {
    onloaded: false,
    $body: $('body'),
    $window: $(window),
    $document: $(document),
    $form_warning: null,
    is_confirm: false,
    form_modified: false,
    code_themes: [],
    is_rtl: $('body').hasClass('rtl'),
  };

  //
  // Helper Functions
  //
  THEMEATELIER_CORE.helper = {

    //
    // Generate UID
    //
    uid: function (prefix) {
      return (prefix || '') + Math.random().toString(36).substr(2, 9);
    },

    // Quote regular expression characters
    //
    preg_quote: function (str) {
      return (str + '').replace(/(\[|\])/g, "\\$1");
    },

    //
    // Reneme input names
    //
    name_nested_replace: function ($selector, field_id) {

      var checks = [];
      var regex = new RegExp(THEMEATELIER_CORE.helper.preg_quote(field_id + '[\\d+]'), 'g');

      $selector.find(':radio').each(function () {
        if (this.checked || this.orginal_checked) {
          this.orginal_checked = true;
        }
      });

      $selector.each(function (index) {
        $(this).find(':input').each(function () {
          this.name = this.name.replace(regex, field_id + '[' + index + ']');
          if (this.orginal_checked) {
            this.checked = true;
          }
        });
      });

    },

    //
    // Debounce
    //
    debounce: function (callback, threshold, immediate) {
      var timeout;
      return function () {
        var context = this, args = arguments;
        var later = function () {
          timeout = null;
          if (!immediate) {
            callback.apply(context, args);
          }
        };
        var callNow = (immediate && !timeout);
        clearTimeout(timeout);
        timeout = setTimeout(later, threshold);
        if (callNow) {
          callback.apply(context, args);
        }
      };
    },

  };

  //
  // Custom clone for textarea and select clone() bug
  //
  $.fn.THEMEATELIER_CORE_clone = function () {

    var base = $.fn.clone.apply(this, arguments),
      clone = this.find('select').add(this.filter('select')),
      cloned = base.find('select').add(base.filter('select'));

    for (var i = 0; i < clone.length; ++i) {
      for (var j = 0; j < clone[i].options.length; ++j) {

        if (clone[i].options[j].selected === true) {
          cloned[i].options[j].selected = true;
        }

      }
    }

    this.find(':radio').each(function () {
      this.orginal_checked = this.checked;
    });

    return base;

  };

  //
  // Expand All Options
  //
  $.fn.THEMEATELIER_CORE_expand_all = function () {
    return this.each(function () {
      $(this).on('click', function (e) {

        e.preventDefault();
        $('.themeatelier-core-wrapper').toggleClass('themeatelier-core-show-all');
        $('.themeatelier-core-section').THEMEATELIER_CORE_reload_script();
        $(this).find('.fa').toggleClass('fa-indent').toggleClass('fa-outdent');

      });
    });
  };

  //
  // Options Navigation
  //
  $.fn.THEMEATELIER_CORE_nav_options = function () {
    return this.each(function () {

      var $nav = $(this),
        $window = $(window),
        $wpwrap = $('#wpwrap'),
        $links = $nav.find('a'),
        $last;

      $window.on('hashchange themeatelier-core.hashchange', function () {

        var hash = window.location.hash.replace('#tab=', '');
        var slug = hash ? hash : $links.first().attr('href').replace('#tab=', '');
        var $link = $('[data-tab-id="' + slug + '"]');

        if ($link.length) {

          $link.closest('.themeatelier-core-tab-item').addClass('themeatelier-core-tab-expanded').siblings().removeClass('themeatelier-core-tab-expanded');

          if ($link.next().is('ul')) {

            $link = $link.next().find('li').first().find('a');
            slug = $link.data('tab-id');

          }

          $links.removeClass('themeatelier-core-active');
          $link.addClass('themeatelier-core-active');

          if ($last) {
            $last.addClass('hidden');
          }

          var $section = $('[data-section-id="' + slug + '"]');

          $section.removeClass('hidden');
          $section.THEMEATELIER_CORE_reload_script();

          $('.themeatelier-core-section-id').val($section.index() + 1);

          $last = $section;

          if ($wpwrap.hasClass('wp-responsive-open')) {
            $('html, body').animate({ scrollTop: ($section.offset().top - 50) }, 200);
            $wpwrap.removeClass('wp-responsive-open');
          }

        }

      }).trigger('themeatelier-core.hashchange');

    });
  };

  //
  // Metabox Tabs
  //
  $.fn.THEMEATELIER_CORE_nav_metabox = function () {
    return this.each(function () {

      var $nav = $(this),
        $links = $nav.find('a'),
        $sections = $nav.parent().find('.themeatelier-core-section'),
        $last;

      $links.each(function (index) {

        $(this).on('click', function (e) {

          e.preventDefault();

          var $link = $(this);

          $links.removeClass('themeatelier-core-active');
          $link.addClass('themeatelier-core-active');

          if ($last !== undefined) {
            $last.addClass('hidden');
          }

          var $section = $sections.eq(index);

          $section.removeClass('hidden');
          $section.THEMEATELIER_CORE_reload_script();

          $last = $section;

        });

      });

      $links.first().trigger('click');

    });
  };

  //
  // Metabox Page Templates Listener
  //
  $.fn.THEMEATELIER_CORE_page_templates = function () {
    if (this.length) {

      $(document).on('change', '.editor-page-attributes__template select, #page_template, .edit-post-post-status + div select', function () {

        var maybe_value = $(this).val() || 'default';

        $('.themeatelier-core-page-templates').removeClass('themeatelier-core-metabox-show').addClass('themeatelier-core-metabox-hide');
        $('.themeatelier-core-page-' + maybe_value.toLowerCase().replace(/[^a-zA-Z0-9]+/g, '-')).removeClass('themeatelier-core-metabox-hide').addClass('themeatelier-core-metabox-show');

      });

    }
  };

  //
  // Metabox Post Formats Listener
  //
  $.fn.THEMEATELIER_CORE_post_formats = function () {
    if (this.length) {

      $(document).on('change', '.editor-post-format select, #formatdiv input[name="post_format"]', function () {

        var maybe_value = $(this).val() || 'default';

        // Fallback for classic editor version
        maybe_value = (maybe_value === '0') ? 'default' : maybe_value;

        $('.themeatelier-core-post-formats').removeClass('themeatelier-core-metabox-show').addClass('themeatelier-core-metabox-hide');
        $('.themeatelier-core-post-format-' + maybe_value).removeClass('themeatelier-core-metabox-hide').addClass('themeatelier-core-metabox-show');

      });

    }
  };

  //
  // Search
  //
  $.fn.THEMEATELIER_CORE_search = function () {
    return this.each(function () {

      var $this = $(this),
        $input = $this.find('input');

      $input.on('change keyup', function () {

        var value = $(this).val(),
          $wrapper = $('.themeatelier-core-wrapper'),
          $section = $wrapper.find('.themeatelier-core-section'),
          $fields = $section.find('> .themeatelier-core-field:not(.themeatelier-core-depend-on)'),
          $titles = $fields.find('> .themeatelier-core-title, .themeatelier-core-search-tags');

        if (value.length > 3) {

          $fields.addClass('themeatelier-core-metabox-hide');
          $wrapper.addClass('themeatelier-core-search-all');

          $titles.each(function () {

            var $title = $(this);

            if ($title.text().match(new RegExp('.*?' + value + '.*?', 'i'))) {

              var $field = $title.closest('.themeatelier-core-field');

              $field.removeClass('themeatelier-core-metabox-hide');
              $field.parent().THEMEATELIER_CORE_reload_script();

            }

          });

        } else {

          $fields.removeClass('themeatelier-core-metabox-hide');
          $wrapper.removeClass('themeatelier-core-search-all');

        }

      });

    });
  };

  //
  // Sticky Header
  //
  $.fn.THEMEATELIER_CORE_sticky = function () {
    return this.each(function () {

      var $this = $(this),
        $window = $(window),
        $inner = $this.find('.themeatelier-core-header-inner'),
        padding = parseInt($inner.css('padding-left')) + parseInt($inner.css('padding-right')),
        offset = 32,
        scrollTop = 0,
        lastTop = 0,
        ticking = false,
        stickyUpdate = function () {

          var offsetTop = $this.offset().top,
            stickyTop = Math.max(offset, offsetTop - scrollTop),
            winWidth = $window.innerWidth();

          if (stickyTop <= offset && winWidth > 782) {
            $inner.css({ width: $this.outerWidth() - padding });
            $this.css({ height: $this.outerHeight() }).addClass('themeatelier-core-sticky');
          } else {
            $inner.removeAttr('style');
            $this.removeAttr('style').removeClass('themeatelier-core-sticky');
          }

        },
        requestTick = function () {

          if (!ticking) {
            requestAnimationFrame(function () {
              stickyUpdate();
              ticking = false;
            });
          }

          ticking = true;

        },
        onSticky = function () {

          scrollTop = $window.scrollTop();
          requestTick();

        };

      $window.on('scroll resize', onSticky);

      onSticky();

    });
  };

  //
  // Dependency System
  //
  $.fn.THEMEATELIER_CORE_dependency = function () {
    return this.each(function () {

      var $this = $(this),
        $fields = $this.children('[data-controller]');

      if ($fields.length) {

        var normal_ruleset = $.THEMEATELIER_CORE_deps.createRuleset(),
          global_ruleset = $.THEMEATELIER_CORE_deps.createRuleset(),
          normal_depends = [],
          global_depends = [];

        $fields.each(function () {

          var $field = $(this),
            controllers = $field.data('controller').split('|'),
            conditions = $field.data('condition').split('|'),
            values = $field.data('value').toString().split('|'),
            is_global = $field.data('depend-global') ? true : false,
            ruleset = (is_global) ? global_ruleset : normal_ruleset;

          $.each(controllers, function (index, depend_id) {

            var value = values[index] || '',
              condition = conditions[index] || conditions[0];

            ruleset = ruleset.createRule('[data-depend-id="' + depend_id + '"]', condition, value);

            ruleset.include($field);

            if (is_global) {
              global_depends.push(depend_id);
            } else {
              normal_depends.push(depend_id);
            }

          });

        });

        if (normal_depends.length) {
          $.THEMEATELIER_CORE_deps.enable($this, normal_ruleset, normal_depends);
        }

        if (global_depends.length) {
          $.THEMEATELIER_CORE_deps.enable(THEMEATELIER_CORE.vars.$body, global_ruleset, global_depends);
        }

      }

    });
  };

  //
  // Field: accordion
  //
  $.fn.THEMEATELIER_CORE_field_accordion = function () {
    return this.each(function () {

      var $titles = $(this).find('.themeatelier-core-accordion-title');

      $titles.on('click', function () {

        var $title = $(this),
          $icon = $title.find('.themeatelier-core-accordion-icon'),
          $content = $title.next();

        if ($icon.hasClass('fa-angle-right')) {
          $icon.removeClass('fa-angle-right').addClass('fa-angle-down');
        } else {
          $icon.removeClass('fa-angle-down').addClass('fa-angle-right');
        }

        if (!$content.data('opened')) {

          $content.THEMEATELIER_CORE_reload_script();
          $content.data('opened', true);

        }

        $content.toggleClass('themeatelier-core-accordion-open');

      });

    });
  };

  //
  // Field: backup
  //
  $.fn.THEMEATELIER_CORE_field_backup = function () {
    return this.each(function () {

      if (window.wp.customize === undefined) { return; }

      var base = this,
        $this = $(this),
        $body = $('body'),
        $import = $this.find('.themeatelier-core-import'),
        $reset = $this.find('.themeatelier-core-reset');

      base.notificationOverlay = function () {

        if (wp.customize.notifications && wp.customize.OverlayNotification) {

          // clear if there is any saved data.
          if (!wp.customize.state('saved').get()) {
            wp.customize.state('changesetStatus').set('trash');
            wp.customize.each(function (setting) { setting._dirty = false; });
            wp.customize.state('saved').set(true);
          }

          // then show a notification overlay
          wp.customize.notifications.add(new wp.customize.OverlayNotification('THEMEATELIER_CORE_field_backup_notification', {
            type: 'default',
            message: '&nbsp;',
            loading: true
          }));

        }

      };

      $reset.on('click', function (e) {

        e.preventDefault();

        if (THEMEATELIER_CORE.vars.is_confirm) {

          base.notificationOverlay();

          window.wp.ajax.post('themeatelier-core-reset', {
            unique: $reset.data('unique'),
            nonce: $reset.data('nonce')
          })
            .done(function (response) {
              window.location.reload(true);
            })
            .fail(function (response) {
              alert(response.error);
              wp.customize.notifications.remove('THEMEATELIER_CORE_field_backup_notification');
            });

        }

      });

      $import.on('click', function (e) {

        e.preventDefault();

        if (THEMEATELIER_CORE.vars.is_confirm) {

          base.notificationOverlay();

          window.wp.ajax.post('themeatelier-core-import', {
            unique: $import.data('unique'),
            nonce: $import.data('nonce'),
            data: $this.find('.themeatelier-core-import-data').val()
          }).done(function (response) {
            window.location.reload(true);
          }).fail(function (response) {
            alert(response.error);
            wp.customize.notifications.remove('THEMEATELIER_CORE_field_backup_notification');
          });

        }

      });

    });
  };

  //
  // Field: background
  //
  $.fn.THEMEATELIER_CORE_field_background = function () {
    return this.each(function () {
      $(this).find('.themeatelier-core--background-image').THEMEATELIER_CORE_reload_script();
    });
  };

  //
  // Field: code_editor
  //
  $.fn.THEMEATELIER_CORE_field_code_editor = function () {
    return this.each(function () {

      if (typeof CodeMirror !== 'function') { return; }

      var $this = $(this),
        $textarea = $this.find('textarea'),
        $inited = $this.find('.CodeMirror'),
        data_editor = $textarea.data('editor');

      if ($inited.length) {
        $inited.remove();
      }

      var interval = setInterval(function () {
        if ($this.is(':visible')) {

          var code_editor = CodeMirror.fromTextArea($textarea[0], data_editor);

          // load code-mirror theme css.
          if (data_editor.theme !== 'default' && THEMEATELIER_CORE.vars.code_themes.indexOf(data_editor.theme) === -1) {

            var $cssLink = $('<link>');

            $('#themeatelier-core-codemirror-css').after($cssLink);

            $cssLink.attr({
              rel: 'stylesheet',
              id: 'themeatelier-core-codemirror-' + data_editor.theme + '-css',
              href: data_editor.cdnURL + '/theme/' + data_editor.theme + '.min.css',
              type: 'text/css',
              media: 'all'
            });

            THEMEATELIER_CORE.vars.code_themes.push(data_editor.theme);

          }

          CodeMirror.modeURL = data_editor.cdnURL + '/mode/%N/%N.min.js';
          CodeMirror.autoLoadMode(code_editor, data_editor.mode);

          code_editor.on('change', function (editor, event) {
            $textarea.val(code_editor.getValue()).trigger('change');
          });

          clearInterval(interval);

        }
      });

    });
  };

  //
  // Field: date
  //
  $.fn.THEMEATELIER_CORE_field_date = function () {
    return this.each(function () {

      var $this = $(this),
        $inputs = $this.find('input'),
        settings = $this.find('.themeatelier-core-date-settings').data('settings'),
        wrapper = '<div class="themeatelier-core-datepicker-wrapper"></div>';

      var defaults = {
        showAnim: '',
        beforeShow: function (input, inst) {
          $(inst.dpDiv).addClass('themeatelier-core-datepicker-wrapper');
        },
        onClose: function (input, inst) {
          $(inst.dpDiv).removeClass('themeatelier-core-datepicker-wrapper');
        },
      };

      settings = $.extend({}, settings, defaults);

      if ($inputs.length === 2) {

        settings = $.extend({}, settings, {
          onSelect: function (selectedDate) {

            var $this = $(this),
              $from = $inputs.first(),
              option = ($inputs.first().attr('id') === $(this).attr('id')) ? 'minDate' : 'maxDate',
              date = $.datepicker.parseDate(settings.dateFormat, selectedDate);

            $inputs.not(this).datepicker('option', option, date);

          }
        });

      }

      $inputs.each(function () {

        var $input = $(this);

        if ($input.hasClass('hasDatepicker')) {
          $input.removeAttr('id').removeClass('hasDatepicker');
        }

        $input.datepicker(settings);

      });

    });
  };

  //
  // Field: datetime
  //
  $.fn.THEMEATELIER_CORE_field_datetime = function () {
    return this.each(function () {

      var $this = $(this),
        $inputs = $this.find('input'),
        settings = $this.find('.themeatelier-core-datetime-settings').data('settings');

      settings = $.extend({}, settings, {
        onReady: function (selectedDates, dateStr, instance) {
          $(instance.calendarContainer).addClass('themeatelier-core-flatpickr');
        },
      });

      if ($inputs.length === 2) {
        settings = $.extend({}, settings, {
          onChange: function (selectedDates, dateStr, instance) {
            if ($(instance.element).data('type') === 'from') {
              $inputs.last().get(0)._flatpickr.set('minDate', selectedDates[0]);
            } else {
              $inputs.first().get(0)._flatpickr.set('maxDate', selectedDates[0]);
            }
          },
        });
      }

      $inputs.each(function () {
        $(this).flatpickr(settings);
      });

    });
  };

  //
  // Field: fieldset
  //
  $.fn.THEMEATELIER_CORE_field_fieldset = function () {
    return this.each(function () {
      $(this).find('.themeatelier-core-fieldset-content').THEMEATELIER_CORE_reload_script();
    });
  };

  //
  // Field: gallery
  //
  $.fn.THEMEATELIER_CORE_field_gallery = function () {
    return this.each(function () {

      var $this = $(this),
        $edit = $this.find('.themeatelier-core-edit-gallery'),
        $clear = $this.find('.themeatelier-core-clear-gallery'),
        $list = $this.find('ul'),
        $input = $this.find('input'),
        $img = $this.find('img'),
        wp_media_frame;

      $this.on('click', '.themeatelier-core-button, .themeatelier-core-edit-gallery', function (e) {

        var $el = $(this),
          ids = $input.val(),
          what = ($el.hasClass('themeatelier-core-edit-gallery')) ? 'edit' : 'add',
          state = (what === 'add' && !ids.length) ? 'gallery' : 'gallery-edit';

        e.preventDefault();

        if (typeof window.wp === 'undefined' || !window.wp.media || !window.wp.media.gallery) { return; }

        // Open media with state
        if (state === 'gallery') {

          wp_media_frame = window.wp.media({
            library: {
              type: 'image'
            },
            frame: 'post',
            state: 'gallery',
            multiple: true
          });

          wp_media_frame.open();

        } else {

          wp_media_frame = window.wp.media.gallery.edit('[gallery ids="' + ids + '"]');

          if (what === 'add') {
            wp_media_frame.setState('gallery-library');
          }

        }

        // Media Update
        wp_media_frame.on('update', function (selection) {

          $list.empty();

          var selectedIds = selection.models.map(function (attachment) {

            var item = attachment.toJSON();
            var thumb = (item.sizes && item.sizes.thumbnail && item.sizes.thumbnail.url) ? item.sizes.thumbnail.url : item.url;

            $list.append('<li><img src="' + thumb + '"></li>');

            return item.id;

          });

          $input.val(selectedIds.join(',')).trigger('change');
          $clear.removeClass('hidden');
          $edit.removeClass('hidden');

        });

      });

      $clear.on('click', function (e) {
        e.preventDefault();
        $list.empty();
        $input.val('').trigger('change');
        $clear.addClass('hidden');
        $edit.addClass('hidden');
      });

    });

  };

  //
  // Field: group
  //
  $.fn.THEMEATELIER_CORE_field_group = function () {
    return this.each(function () {

      var $this = $(this),
        $fieldset = $this.children('.themeatelier-core-fieldset'),
        $group = $fieldset.length ? $fieldset : $this,
        $wrapper = $group.children('.themeatelier-core-cloneable-wrapper'),
        $hidden = $group.children('.themeatelier-core-cloneable-hidden'),
        $max = $group.children('.themeatelier-core-cloneable-max'),
        $min = $group.children('.themeatelier-core-cloneable-min'),
        title_by = $wrapper.data('title-by'),
        title_prefix = $wrapper.data('title-by-prefix'),
        field_id = $wrapper.data('field-id'),
        is_number = Boolean(Number($wrapper.data('title-number'))),
        max = parseInt($wrapper.data('max')),
        min = parseInt($wrapper.data('min'));

      // clear accordion arrows if multi-instance
      if ($wrapper.hasClass('ui-accordion')) {
        $wrapper.find('.ui-accordion-header-icon').remove();
      }

      var update_title_numbers = function ($selector) {
        $selector.find('.themeatelier-core-cloneable-title-number').each(function (index) {
          $(this).html(($(this).closest('.themeatelier-core-cloneable-item').index() + 1) + '.');
        });
      };

      $wrapper.accordion({
        header: '> .themeatelier-core-cloneable-item > .themeatelier-core-cloneable-title',
        collapsible: true,
        active: false,
        animate: false,
        heightStyle: 'content',
        icons: {
          'header': 'themeatelier-core-cloneable-header-icon icofont-simple-right',
          'activeHeader': 'themeatelier-core-cloneable-header-icon icofont-rounded-down'
        },
        activate: function (event, ui) {

          var $panel = ui.newPanel;
          var $header = ui.newHeader;

          if ($panel.length && !$panel.data('opened')) {

            var $title = $header.find('.themeatelier-core-cloneable-value');
            var inputs = [];

            $.each(title_by, function (key, title_key) {
              inputs.push($panel.find('[data-depend-id="' + title_key + '"]'));
            });

            $.each(inputs, function (key, $input) {

              $input.on('change keyup themeatelier-core.keyup', function () {

                var titles = [];

                $.each(inputs, function (key, $input) {

                  var input_value = $input.val();

                  if (input_value) {
                    titles.push(input_value);
                  }

                });

                if (titles.length) {
                  $title.text(titles.join(title_prefix));
                }

              }).trigger('themeatelier-core.keyup');

            });

            $panel.THEMEATELIER_CORE_reload_script();
            $panel.data('opened', true);
            $panel.data('retry', false);

          } else if ($panel.data('retry')) {

            $panel.THEMEATELIER_CORE_reload_script_retry();
            $panel.data('retry', false);

          }

        }
      });

      $wrapper.sortable({
        axis: 'y',
        handle: '.themeatelier-core-cloneable-title,.themeatelier-core-cloneable-sort',
        helper: 'original',
        cursor: 'move',
        placeholder: 'widget-placeholder',
        start: function (event, ui) {

          $wrapper.accordion({ active: false });
          $wrapper.sortable('refreshPositions');
          ui.item.children('.themeatelier-core-cloneable-content').data('retry', true);

        },
        update: function (event, ui) {

          THEMEATELIER_CORE.helper.name_nested_replace($wrapper.children('.themeatelier-core-cloneable-item'), field_id);
          $wrapper.THEMEATELIER_CORE_customizer_refresh();

          if (is_number) {
            update_title_numbers($wrapper);
          }

        },
      });

      $group.children('.themeatelier-core-cloneable-add').on('click', function (e) {

        e.preventDefault();

        var count = $wrapper.children('.themeatelier-core-cloneable-item').length;

        $min.hide();

        if (max && (count + 1) > max) {
          $max.show();
          return;
        }

        var $cloned_item = $hidden.THEMEATELIER_CORE_clone(true);

        $cloned_item.removeClass('themeatelier-core-cloneable-hidden');

        $cloned_item.find(':input[name!="_pseudo"]').each(function () {
          this.name = this.name.replace('___', '').replace(field_id + '[0]', field_id + '[' + count + ']');
        });

        $wrapper.append($cloned_item);
        $wrapper.accordion('refresh');
        $wrapper.accordion({ active: count });
        $wrapper.THEMEATELIER_CORE_customizer_refresh();
        $wrapper.THEMEATELIER_CORE_customizer_listen({ closest: true });

        if (is_number) {
          update_title_numbers($wrapper);
        }

      });

      var event_clone = function (e) {

        e.preventDefault();

        var count = $wrapper.children('.themeatelier-core-cloneable-item').length;

        $min.hide();

        if (max && (count + 1) > max) {
          $max.show();
          return;
        }

        var $this = $(this),
          $parent = $this.parent().parent(),
          $cloned_helper = $parent.children('.themeatelier-core-cloneable-helper').THEMEATELIER_CORE_clone(true),
          $cloned_title = $parent.children('.themeatelier-core-cloneable-title').THEMEATELIER_CORE_clone(),
          $cloned_content = $parent.children('.themeatelier-core-cloneable-content').THEMEATELIER_CORE_clone(),
          $cloned_item = $('<div class="themeatelier-core-cloneable-item" />');

        $cloned_item.append($cloned_helper);
        $cloned_item.append($cloned_title);
        $cloned_item.append($cloned_content);

        $wrapper.children().eq($parent.index()).after($cloned_item);

        THEMEATELIER_CORE.helper.name_nested_replace($wrapper.children('.themeatelier-core-cloneable-item'), field_id);

        $wrapper.accordion('refresh');
        $wrapper.THEMEATELIER_CORE_customizer_refresh();
        $wrapper.THEMEATELIER_CORE_customizer_listen({ closest: true });

        if (is_number) {
          update_title_numbers($wrapper);
        }

      };

      $wrapper.children('.themeatelier-core-cloneable-item').children('.themeatelier-core-cloneable-helper').on('click', '.themeatelier-core-cloneable-clone', event_clone);
      $group.children('.themeatelier-core-cloneable-hidden').children('.themeatelier-core-cloneable-helper').on('click', '.themeatelier-core-cloneable-clone', event_clone);

      var event_remove = function (e) {

        e.preventDefault();

        var count = $wrapper.children('.themeatelier-core-cloneable-item').length;

        $max.hide();
        $min.hide();

        if (min && (count - 1) < min) {
          $min.show();
          return;
        }

        $(this).closest('.themeatelier-core-cloneable-item').remove();

        THEMEATELIER_CORE.helper.name_nested_replace($wrapper.children('.themeatelier-core-cloneable-item'), field_id);

        $wrapper.THEMEATELIER_CORE_customizer_refresh();

        if (is_number) {
          update_title_numbers($wrapper);
        }

      };

      $wrapper.children('.themeatelier-core-cloneable-item').children('.themeatelier-core-cloneable-helper').on('click', '.themeatelier-core-cloneable-remove', event_remove);
      $group.children('.themeatelier-core-cloneable-hidden').children('.themeatelier-core-cloneable-helper').on('click', '.themeatelier-core-cloneable-remove', event_remove);

    });
  };

  //
  // Field: icon
  //
  $.fn.THEMEATELIER_CORE_field_icon = function () {
    return this.each(function () {

      var $this = $(this);

      $this.on('click', '.themeatelier-core-icon-add', function (e) {

        e.preventDefault();

        var $button = $(this);
        var $modal = $('#themeatelier-core-modal-icon');

        $modal.removeClass('hidden');

        THEMEATELIER_CORE.vars.$icon_target = $this;

        if (!THEMEATELIER_CORE.vars.icon_modal_loaded) {

          $modal.find('.themeatelier-core-modal-loading').show();

          window.wp.ajax.post('themeatelier-core-get-icons', {
            nonce: $button.data('nonce')
          }).done(function (response) {

            $modal.find('.themeatelier-core-modal-loading').hide();

            THEMEATELIER_CORE.vars.icon_modal_loaded = true;

            var $load = $modal.find('.themeatelier-core-modal-load').html(response.content);

            $load.on('click', 'i', function (e) {

              e.preventDefault();

              var icon = $(this).attr('title');

              THEMEATELIER_CORE.vars.$icon_target.find('.themeatelier-core-icon-preview i').removeAttr('class').addClass(icon);
              THEMEATELIER_CORE.vars.$icon_target.find('.themeatelier-core-icon-preview').removeClass('hidden');
              THEMEATELIER_CORE.vars.$icon_target.find('.themeatelier-core-icon-remove').removeClass('hidden');
              THEMEATELIER_CORE.vars.$icon_target.find('input').val(icon).trigger('change');

              $modal.addClass('hidden');

            });

            $modal.on('change keyup', '.themeatelier-core-icon-search', function () {

              var value = $(this).val(),
                $icons = $load.find('i');

              $icons.each(function () {

                var $elem = $(this);

                if ($elem.attr('title').search(new RegExp(value, 'i')) < 0) {
                  $elem.hide();
                } else {
                  $elem.show();
                }

              });

            });

            $modal.on('click', '.themeatelier-core-modal-close, .themeatelier-core-modal-overlay', function () {
              $modal.addClass('hidden');
            });

          }).fail(function (response) {
            $modal.find('.themeatelier-core-modal-loading').hide();
            $modal.find('.themeatelier-core-modal-load').html(response.error);
            $modal.on('click', function () {
              $modal.addClass('hidden');
            });
          });
        }

      });

      $this.on('click', '.themeatelier-core-icon-remove', function (e) {
        e.preventDefault();
        $this.find('.themeatelier-core-icon-preview').addClass('hidden');
        $this.find('input').val('').trigger('change');
        $(this).addClass('hidden');
      });

    });
  };

  //
  // Field: map
  //
  $.fn.THEMEATELIER_CORE_field_map = function () {
    return this.each(function () {

      if (typeof L === 'undefined') { return; }

      var $this = $(this),
        $map = $this.find('.themeatelier-core--map-osm'),
        $search_input = $this.find('.themeatelier-core--map-search input'),
        $latitude = $this.find('.themeatelier-core--latitude'),
        $longitude = $this.find('.themeatelier-core--longitude'),
        $zoom = $this.find('.themeatelier-core--zoom'),
        map_data = $map.data('map');

      var mapInit = L.map($map.get(0), map_data);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(mapInit);

      var mapMarker = L.marker(map_data.center, { draggable: true }).addTo(mapInit);

      var update_latlng = function (data) {
        $latitude.val(data.lat);
        $longitude.val(data.lng);
        $zoom.val(mapInit.getZoom());
      };

      mapInit.on('click', function (data) {
        mapMarker.setLatLng(data.latlng);
        update_latlng(data.latlng);
      });

      mapInit.on('zoom', function () {
        update_latlng(mapMarker.getLatLng());
      });

      mapMarker.on('drag', function () {
        update_latlng(mapMarker.getLatLng());
      });

      if (!$search_input.length) {
        $search_input = $('[data-depend-id="' + $this.find('.themeatelier-core--address-field').data('address-field') + '"]');
      }

      var cache = {};

      $search_input.autocomplete({
        source: function (request, response) {

          var term = request.term;

          if (term in cache) {
            response(cache[term]);
            return;
          }

          $.get('https://nominatim.openstreetmap.org/search', {
            format: 'json',
            q: term,
          }, function (results) {

            var data;

            if (results.length) {
              data = results.map(function (item) {
                return {
                  value: item.display_name,
                  label: item.display_name,
                  lat: item.lat,
                  lon: item.lon
                };
              }, 'json');
            } else {
              data = [{
                value: 'no-data',
                label: 'No Results.'
              }];
            }

            cache[term] = data;
            response(data);

          });

        },
        select: function (event, ui) {

          if (ui.item.value === 'no-data') { return false; }

          var latLng = L.latLng(ui.item.lat, ui.item.lon);

          mapInit.panTo(latLng);
          mapMarker.setLatLng(latLng);
          update_latlng(latLng);

        },
        create: function (event, ui) {
          $(this).autocomplete('widget').addClass('themeatelier-core-map-ui-autocomplate');
        }
      });

      var input_update_latlng = function () {

        var latLng = L.latLng($latitude.val(), $longitude.val());

        mapInit.panTo(latLng);
        mapMarker.setLatLng(latLng);

      };

      $latitude.on('change', input_update_latlng);
      $longitude.on('change', input_update_latlng);

    });
  };

  //
  // Field: link
  //
  $.fn.THEMEATELIER_CORE_field_link = function () {
    return this.each(function () {

      var $this = $(this),
        $link = $this.find('.themeatelier-core--link'),
        $add = $this.find('.themeatelier-core--add'),
        $edit = $this.find('.themeatelier-core--edit'),
        $remove = $this.find('.themeatelier-core--remove'),
        $result = $this.find('.themeatelier-core--result'),
        uniqid = THEMEATELIER_CORE.helper.uid('themeatelier-core-wplink-textarea-');

      $add.on('click', function (e) {

        e.preventDefault();

        window.wpLink.open(uniqid);

      });

      $edit.on('click', function (e) {

        e.preventDefault();

        $add.trigger('click');

        $('#wp-link-url').val($this.find('.themeatelier-core--url').val());
        $('#wp-link-text').val($this.find('.themeatelier-core--text').val());
        $('#wp-link-target').prop('checked', ($this.find('.themeatelier-core--target').val() === '_blank'));

      });

      $remove.on('click', function (e) {

        e.preventDefault();

        $this.find('.themeatelier-core--url').val('').trigger('change');
        $this.find('.themeatelier-core--text').val('');
        $this.find('.themeatelier-core--target').val('');

        $add.removeClass('hidden');
        $edit.addClass('hidden');
        $remove.addClass('hidden');
        $result.parent().addClass('hidden');

      });

      $link.attr('id', uniqid).on('change', function () {

        var atts = window.wpLink.getAttrs(),
          href = atts.href,
          text = $('#wp-link-text').val(),
          target = (atts.target) ? atts.target : '';

        $this.find('.themeatelier-core--url').val(href).trigger('change');
        $this.find('.themeatelier-core--text').val(text);
        $this.find('.themeatelier-core--target').val(target);

        $result.html('{url:"' + href + '", text:"' + text + '", target:"' + target + '"}');

        $add.addClass('hidden');
        $edit.removeClass('hidden');
        $remove.removeClass('hidden');
        $result.parent().removeClass('hidden');

      });

    });

  };

  //
  // Field: media
  //
  $.fn.THEMEATELIER_CORE_field_media = function () {
    return this.each(function () {

      var $this = $(this),
        $upload_button = $this.find('.themeatelier-core--button'),
        $remove_button = $this.find('.themeatelier-core--remove'),
        $library = $upload_button.data('library') && $upload_button.data('library').split(',') || '',
        $auto_attributes = ($this.hasClass('themeatelier-core-assign-field-background')) ? $this.closest('.themeatelier-core-field-background').find('.themeatelier-core--auto-attributes') : false,
        wp_media_frame;

      $upload_button.on('click', function (e) {

        e.preventDefault();

        if (typeof window.wp === 'undefined' || !window.wp.media || !window.wp.media.gallery) {
          return;
        }

        if (wp_media_frame) {
          wp_media_frame.open();
          return;
        }

        wp_media_frame = window.wp.media({
          library: {
            type: $library
          }
        });

        wp_media_frame.on('select', function () {

          var thumbnail;
          var attributes = wp_media_frame.state().get('selection').first().attributes;
          var preview_size = $upload_button.data('preview-size') || 'thumbnail';

          if ($library.length && $library.indexOf(attributes.subtype) === -1 && $library.indexOf(attributes.type) === -1) {
            return;
          }

          $this.find('.themeatelier-core--id').val(attributes.id);
          $this.find('.themeatelier-core--width').val(attributes.width);
          $this.find('.themeatelier-core--height').val(attributes.height);
          $this.find('.themeatelier-core--alt').val(attributes.alt);
          $this.find('.themeatelier-core--title').val(attributes.title);
          $this.find('.themeatelier-core--description').val(attributes.description);

          if (typeof attributes.sizes !== 'undefined' && typeof attributes.sizes.thumbnail !== 'undefined' && preview_size === 'thumbnail') {
            thumbnail = attributes.sizes.thumbnail.url;
          } else if (typeof attributes.sizes !== 'undefined' && typeof attributes.sizes.full !== 'undefined') {
            thumbnail = attributes.sizes.full.url;
          } else if (attributes.type === 'image') {
            thumbnail = attributes.url;
          } else {
            thumbnail = attributes.icon;
          }

          if ($auto_attributes) {
            $auto_attributes.removeClass('themeatelier-core--attributes-hidden');
          }

          $remove_button.removeClass('hidden');

          $this.find('.themeatelier-core--preview').removeClass('hidden');
          $this.find('.themeatelier-core--src').attr('src', thumbnail);
          $this.find('.themeatelier-core--thumbnail').val(thumbnail);
          $this.find('.themeatelier-core--url').val(attributes.url).trigger('change');

        });

        wp_media_frame.open();

      });

      $remove_button.on('click', function (e) {

        e.preventDefault();

        if ($auto_attributes) {
          $auto_attributes.addClass('themeatelier-core--attributes-hidden');
        }

        $remove_button.addClass('hidden');
        $this.find('input').val('');
        $this.find('.themeatelier-core--preview').addClass('hidden');
        $this.find('.themeatelier-core--url').trigger('change');

      });

    });

  };

  //
  // Field: repeater
  //
  $.fn.THEMEATELIER_CORE_field_repeater = function () {
    return this.each(function () {

      var $this = $(this),
        $fieldset = $this.children('.themeatelier-core-fieldset'),
        $repeater = $fieldset.length ? $fieldset : $this,
        $wrapper = $repeater.children('.themeatelier-core-repeater-wrapper'),
        $hidden = $repeater.children('.themeatelier-core-repeater-hidden'),
        $max = $repeater.children('.themeatelier-core-repeater-max'),
        $min = $repeater.children('.themeatelier-core-repeater-min'),
        field_id = $wrapper.data('field-id'),
        max = parseInt($wrapper.data('max')),
        min = parseInt($wrapper.data('min'));

      $wrapper.children('.themeatelier-core-repeater-item').children('.themeatelier-core-repeater-content').THEMEATELIER_CORE_reload_script();

      $wrapper.sortable({
        axis: 'y',
        handle: '.themeatelier-core-repeater-sort',
        helper: 'original',
        cursor: 'move',
        placeholder: 'widget-placeholder',
        update: function (event, ui) {

          THEMEATELIER_CORE.helper.name_nested_replace($wrapper.children('.themeatelier-core-repeater-item'), field_id);
          $wrapper.THEMEATELIER_CORE_customizer_refresh();
          ui.item.THEMEATELIER_CORE_reload_script_retry();

        }
      });

      $repeater.children('.themeatelier-core-repeater-add').on('click', function (e) {

        e.preventDefault();

        var count = $wrapper.children('.themeatelier-core-repeater-item').length;

        $min.hide();

        if (max && (count + 1) > max) {
          $max.show();
          return;
        }

        var $cloned_item = $hidden.THEMEATELIER_CORE_clone(true);

        $cloned_item.removeClass('themeatelier-core-repeater-hidden');

        $cloned_item.find(':input[name!="_pseudo"]').each(function () {
          this.name = this.name.replace('___', '').replace(field_id + '[0]', field_id + '[' + count + ']');
        });

        $wrapper.append($cloned_item);
        $cloned_item.children('.themeatelier-core-repeater-content').THEMEATELIER_CORE_reload_script();
        $wrapper.THEMEATELIER_CORE_customizer_refresh();
        $wrapper.THEMEATELIER_CORE_customizer_listen({ closest: true });

      });

      var event_clone = function (e) {

        e.preventDefault();

        var count = $wrapper.children('.themeatelier-core-repeater-item').length;

        $min.hide();

        if (max && (count + 1) > max) {
          $max.show();
          return;
        }

        var $this = $(this),
          $parent = $this.parent().parent().parent(),
          $cloned_content = $parent.children('.themeatelier-core-repeater-content').THEMEATELIER_CORE_clone(),
          $cloned_helper = $parent.children('.themeatelier-core-repeater-helper').THEMEATELIER_CORE_clone(true),
          $cloned_item = $('<div class="themeatelier-core-repeater-item" />');

        $cloned_item.append($cloned_content);
        $cloned_item.append($cloned_helper);

        $wrapper.children().eq($parent.index()).after($cloned_item);

        $cloned_item.children('.themeatelier-core-repeater-content').THEMEATELIER_CORE_reload_script();

        THEMEATELIER_CORE.helper.name_nested_replace($wrapper.children('.themeatelier-core-repeater-item'), field_id);

        $wrapper.THEMEATELIER_CORE_customizer_refresh();
        $wrapper.THEMEATELIER_CORE_customizer_listen({ closest: true });

      };

      $wrapper.children('.themeatelier-core-repeater-item').children('.themeatelier-core-repeater-helper').on('click', '.themeatelier-core-repeater-clone', event_clone);
      $repeater.children('.themeatelier-core-repeater-hidden').children('.themeatelier-core-repeater-helper').on('click', '.themeatelier-core-repeater-clone', event_clone);

      var event_remove = function (e) {

        e.preventDefault();

        var count = $wrapper.children('.themeatelier-core-repeater-item').length;

        $max.hide();
        $min.hide();

        if (min && (count - 1) < min) {
          $min.show();
          return;
        }

        $(this).closest('.themeatelier-core-repeater-item').remove();

        THEMEATELIER_CORE.helper.name_nested_replace($wrapper.children('.themeatelier-core-repeater-item'), field_id);

        $wrapper.THEMEATELIER_CORE_customizer_refresh();

      };

      $wrapper.children('.themeatelier-core-repeater-item').children('.themeatelier-core-repeater-helper').on('click', '.themeatelier-core-repeater-remove', event_remove);
      $repeater.children('.themeatelier-core-repeater-hidden').children('.themeatelier-core-repeater-helper').on('click', '.themeatelier-core-repeater-remove', event_remove);

    });
  };

  //
  // Field: slider
  //
  $.fn.THEMEATELIER_CORE_field_slider = function () {
    return this.each(function () {

      var $this = $(this),
        $input = $this.find('input'),
        $slider = $this.find('.themeatelier-core-slider-ui'),
        data = $input.data(),
        value = $input.val() || 0;

      if ($slider.hasClass('ui-slider')) {
        $slider.empty();
      }

      $slider.slider({
        range: 'min',
        value: value,
        min: data.min || 0,
        max: data.max || 100,
        step: data.step || 1,
        slide: function (e, o) {
          $input.val(o.value).trigger('change');
        }
      });

      $input.on('keyup', function () {
        $slider.slider('value', $input.val());
      });

    });
  };

  //
  // Field: sortable
  //
  $.fn.THEMEATELIER_CORE_field_sortable = function () {
    return this.each(function () {

      var $sortable = $(this).find('.themeatelier-core-sortable');

      $sortable.sortable({
        axis: 'y',
        helper: 'original',
        cursor: 'move',
        placeholder: 'widget-placeholder',
        update: function (event, ui) {
          $sortable.THEMEATELIER_CORE_customizer_refresh();
        }
      });

      $sortable.find('.themeatelier-core-sortable-content').THEMEATELIER_CORE_reload_script();

    });
  };

  //
  // Field: sorter
  //
  $.fn.THEMEATELIER_CORE_field_sorter = function () {
    return this.each(function () {

      var $this = $(this),
        $enabled = $this.find('.themeatelier-core-enabled'),
        $has_disabled = $this.find('.themeatelier-core-disabled'),
        $disabled = ($has_disabled.length) ? $has_disabled : false;

      $enabled.sortable({
        connectWith: $disabled,
        placeholder: 'ui-sortable-placeholder',
        update: function (event, ui) {

          var $el = ui.item.find('input');

          if (ui.item.parent().hasClass('themeatelier-core-enabled')) {
            $el.attr('name', $el.attr('name').replace('disabled', 'enabled'));
          } else {
            $el.attr('name', $el.attr('name').replace('enabled', 'disabled'));
          }

          $this.THEMEATELIER_CORE_customizer_refresh();

        }
      });

      if ($disabled) {

        $disabled.sortable({
          connectWith: $enabled,
          placeholder: 'ui-sortable-placeholder',
          update: function (event, ui) {
            $this.THEMEATELIER_CORE_customizer_refresh();
          }
        });

      }

    });
  };

  //
  // Field: spinner
  //
  $.fn.THEMEATELIER_CORE_field_spinner = function () {
    return this.each(function () {

      var $this = $(this),
        $input = $this.find('input'),
        $inited = $this.find('.ui-button'),
        data = $input.data();

      if ($inited.length) {
        $inited.remove();
      }

      $input.spinner({
        min: data.min || 0,
        max: data.max || 100,
        step: data.step || 1,
        create: function (event, ui) {
          if (data.unit) {
            $input.after('<span class="ui-button themeatelier-core--unit">' + data.unit + '</span>');
          }
        },
        spin: function (event, ui) {
          $input.val(ui.value).trigger('change');
        }
      });

    });
  };

  //
  // Field: switcher
  //
  $.fn.THEMEATELIER_CORE_field_switcher = function () {
    return this.each(function () {

      var $switcher = $(this).find('.themeatelier-core--switcher');

      $switcher.on('click', function () {

        var value = 0;
        var $input = $switcher.find('input');

        if ($switcher.hasClass('themeatelier-core--active')) {
          $switcher.removeClass('themeatelier-core--active');
        } else {
          value = 1;
          $switcher.addClass('themeatelier-core--active');
        }

        $input.val(value).trigger('change');

      });

    });
  };

  //
  // Field: tabbed
  //
  $.fn.THEMEATELIER_CORE_field_tabbed = function () {
    return this.each(function () {

      var $this = $(this),
        $links = $this.find('.themeatelier-core-tabbed-nav a'),
        $contents = $this.find('.themeatelier-core-tabbed-content');

      $contents.eq(0).THEMEATELIER_CORE_reload_script();

      $links.on('click', function (e) {

        e.preventDefault();

        var $link = $(this),
          index = $link.index(),
          $content = $contents.eq(index);

        $link.addClass('themeatelier-core-tabbed-active').siblings().removeClass('themeatelier-core-tabbed-active');
        $content.THEMEATELIER_CORE_reload_script();
        $content.removeClass('hidden').siblings().addClass('hidden');

      });

    });
  };
  //
  // Field: section_tab
  //
  $.fn.THEMEATELIER_CORE_field_section_tab = function () {
    return this.each(function () {

      var $this = $(this),
        $links = $this.find('.themeatelier-core-section_tab-nav a'),
        $contents = $this.find('.themeatelier-core-section_tab-content');

      $contents.eq(0).THEMEATELIER_CORE_reload_script();

      $links.on('click', function (e) {

        e.preventDefault();

        var $link = $(this),
          index = $link.index(),
          $content = $contents.eq(index);

        $link.addClass('themeatelier-core-section_tab-active').siblings().removeClass('themeatelier-core-section_tab-active');
        $content.THEMEATELIER_CORE_reload_script();
        $content.removeClass('hidden').siblings().addClass('hidden');

      });

    });
  };

  //
  // Field: typography
  //
  $.fn.THEMEATELIER_CORE_field_typography = function () {
    return this.each(function () {

      var base = this;
      var $this = $(this);
      var loaded_fonts = [];
      var webfonts = THEMEATELIER_CORE_typography_json.webfonts;
      var googlestyles = THEMEATELIER_CORE_typography_json.googlestyles;
      var defaultstyles = THEMEATELIER_CORE_typography_json.defaultstyles;

      //
      //
      // Sanitize google font subset
      base.sanitize_subset = function (subset) {
        subset = subset.replace('-ext', ' Extended');
        subset = subset.charAt(0).toUpperCase() + subset.slice(1);
        return subset;
      };

      //
      //
      // Sanitize google font styles (weight and style)
      base.sanitize_style = function (style) {
        return googlestyles[style] ? googlestyles[style] : style;
      };

      //
      //
      // Load google font
      base.load_google_font = function (font_family, weight, style) {

        if (font_family && typeof WebFont === 'object') {

          weight = weight ? weight.replace('normal', '') : '';
          style = style ? style.replace('normal', '') : '';

          if (weight || style) {
            font_family = font_family + ':' + weight + style;
          }

          if (loaded_fonts.indexOf(font_family) === -1) {
            WebFont.load({ google: { families: [font_family] } });
          }

          loaded_fonts.push(font_family);

        }

      };

      //
      //
      // Append select options
      base.append_select_options = function ($select, options, condition, type, is_multi) {

        $select.find('option').not(':first').remove();

        var opts = '';

        $.each(options, function (key, value) {

          var selected;
          var name = value;

          // is_multi
          if (is_multi) {
            selected = (condition && condition.indexOf(value) !== -1) ? ' selected' : '';
          } else {
            selected = (condition && condition === value) ? ' selected' : '';
          }

          if (type === 'subset') {
            name = base.sanitize_subset(value);
          } else if (type === 'style') {
            name = base.sanitize_style(value);
          }

          opts += '<option value="' + value + '"' + selected + '>' + name + '</option>';

        });

        $select.append(opts).trigger('themeatelier-core.change').trigger('chosen:updated');

      };

      base.init = function () {

        //
        //
        // Constants
        var selected_styles = [];
        var $typography = $this.find('.themeatelier-core--typography');
        var $type = $this.find('.themeatelier-core--type');
        var $styles = $this.find('.themeatelier-core--block-font-style');
        var unit = $typography.data('unit');
        var line_height_unit = $typography.data('line-height-unit');
        var exclude_fonts = $typography.data('exclude') ? $typography.data('exclude').split(',') : [];

        //
        //
        // Chosen init
        if ($this.find('.themeatelier-core--chosen').length) {

          var $chosen_selects = $this.find('select');

          $chosen_selects.each(function () {

            var $chosen_select = $(this),
              $chosen_inited = $chosen_select.parent().find('.chosen-container');

            if ($chosen_inited.length) {
              $chosen_inited.remove();
            }

            $chosen_select.chosen({
              allow_single_deselect: true,
              disable_search_threshold: 15,
              width: '100%'
            });

          });

        }

        //
        //
        // Font family select
        var $font_family_select = $this.find('.themeatelier-core--font-family');
        var first_font_family = $font_family_select.val();

        // Clear default font family select options
        $font_family_select.find('option').not(':first-child').remove();

        var opts = '';

        $.each(webfonts, function (type, group) {

          // Check for exclude fonts
          if (exclude_fonts && exclude_fonts.indexOf(type) !== -1) { return; }

          opts += '<optgroup label="' + group.label + '">';

          $.each(group.fonts, function (key, value) {

            // use key if value is object
            value = (typeof value === 'object') ? key : value;
            var selected = (value === first_font_family) ? ' selected' : '';
            opts += '<option value="' + value + '" data-type="' + type + '"' + selected + '>' + value + '</option>';

          });

          opts += '</optgroup>';

        });

        // Append google font select options
        $font_family_select.append(opts).trigger('chosen:updated');

        //
        //
        // Font style select
        var $font_style_block = $this.find('.themeatelier-core--block-font-style');

        if ($font_style_block.length) {

          var $font_style_select = $this.find('.themeatelier-core--font-style-select');
          var first_style_value = $font_style_select.val() ? $font_style_select.val().replace(/normal/g, '') : '';

          //
          // Font Style on on change listener
          $font_style_select.on('change themeatelier-core.change', function (event) {

            var style_value = $font_style_select.val();

            // set a default value
            if (!style_value && selected_styles && selected_styles.indexOf('normal') === -1) {
              style_value = selected_styles[0];
            }

            // set font weight, for eg. replacing 800italic to 800
            var font_normal = (style_value && style_value !== 'italic' && style_value === 'normal') ? 'normal' : '';
            var font_weight = (style_value && style_value !== 'italic' && style_value !== 'normal') ? style_value.replace('italic', '') : font_normal;
            var font_style = (style_value && style_value.substr(-6) === 'italic') ? 'italic' : '';

            $this.find('.themeatelier-core--font-weight').val(font_weight);
            $this.find('.themeatelier-core--font-style').val(font_style);

          });

          //
          //
          // Extra font style select
          var $extra_font_style_block = $this.find('.themeatelier-core--block-extra-styles');

          if ($extra_font_style_block.length) {
            var $extra_font_style_select = $this.find('.themeatelier-core--extra-styles');
            var first_extra_style_value = $extra_font_style_select.val();
          }

        }

        //
        //
        // Subsets select
        var $subset_block = $this.find('.themeatelier-core--block-subset');
        if ($subset_block.length) {
          var $subset_select = $this.find('.themeatelier-core--subset');
          var first_subset_select_value = $subset_select.val();
          var subset_multi_select = $subset_select.data('multiple') || false;
        }

        //
        //
        // Backup font family
        var $backup_font_family_block = $this.find('.themeatelier-core--block-backup-font-family');

        //
        //
        // Font Family on Change Listener
        $font_family_select.on('change themeatelier-core.change', function (event) {

          // Hide subsets on change
          if ($subset_block.length) {
            $subset_block.addClass('hidden');
          }

          // Hide extra font style on change
          if ($extra_font_style_block.length) {
            $extra_font_style_block.addClass('hidden');
          }

          // Hide backup font family on change
          if ($backup_font_family_block.length) {
            $backup_font_family_block.addClass('hidden');
          }

          var $selected = $font_family_select.find(':selected');
          var value = $selected.val();
          var type = $selected.data('type');

          if (type && value) {

            // Show backup fonts if font type google or custom
            if ((type === 'google' || type === 'custom') && $backup_font_family_block.length) {
              $backup_font_family_block.removeClass('hidden');
            }

            // Appending font style select options
            if ($font_style_block.length) {

              // set styles for multi and normal style selectors
              var styles = defaultstyles;

              // Custom or gogle font styles
              if (type === 'google' && webfonts[type].fonts[value][0]) {
                styles = webfonts[type].fonts[value][0];
              } else if (type === 'custom' && webfonts[type].fonts[value]) {
                styles = webfonts[type].fonts[value];
              }

              selected_styles = styles;

              // Set selected style value for avoid load errors
              var set_auto_style = (styles.indexOf('normal') !== -1) ? 'normal' : styles[0];
              var set_style_value = (first_style_value && styles.indexOf(first_style_value) !== -1) ? first_style_value : set_auto_style;

              // Append style select options
              base.append_select_options($font_style_select, styles, set_style_value, 'style');

              // Clear first value
              first_style_value = false;

              // Show style select after appended
              $font_style_block.removeClass('hidden');

              // Appending extra font style select options
              if (type === 'google' && $extra_font_style_block.length && styles.length > 1) {

                // Append extra-style select options
                base.append_select_options($extra_font_style_select, styles, first_extra_style_value, 'style', true);

                // Clear first value
                first_extra_style_value = false;

                // Show style select after appended
                $extra_font_style_block.removeClass('hidden');

              }

            }

            // Appending google fonts subsets select options
            if (type === 'google' && $subset_block.length && webfonts[type].fonts[value][1]) {

              var subsets = webfonts[type].fonts[value][1];
              var set_auto_subset = (subsets.length < 2 && subsets[0] !== 'latin') ? subsets[0] : '';
              var set_subset_value = (first_subset_select_value && subsets.indexOf(first_subset_select_value) !== -1) ? first_subset_select_value : set_auto_subset;

              // check for multiple subset select
              set_subset_value = (subset_multi_select && first_subset_select_value) ? first_subset_select_value : set_subset_value;

              base.append_select_options($subset_select, subsets, set_subset_value, 'subset', subset_multi_select);

              first_subset_select_value = false;

              $subset_block.removeClass('hidden');

            }

          } else {

            // Clear Styles
            $styles.find(':input').val('');

            // Clear subsets options if type and value empty
            if ($subset_block.length) {
              $subset_select.find('option').not(':first-child').remove();
              $subset_select.trigger('chosen:updated');
            }

            // Clear font styles options if type and value empty
            if ($font_style_block.length) {
              $font_style_select.find('option').not(':first-child').remove();
              $font_style_select.trigger('chosen:updated');
            }

          }

          // Update font type input value
          $type.val(type);

        }).trigger('themeatelier-core.change');

        //
        //
        // Preview
        var $preview_block = $this.find('.themeatelier-core--block-preview');

        if ($preview_block.length) {

          var $preview = $this.find('.themeatelier-core--preview');

          // Set preview styles on change
          $this.on('change', THEMEATELIER_CORE.helper.debounce(function (event) {

            $preview_block.removeClass('hidden');

            var font_family = $font_family_select.val(),
              font_weight = $this.find('.themeatelier-core--font-weight').val(),
              font_style = $this.find('.themeatelier-core--font-style').val(),
              font_size = $this.find('.themeatelier-core--font-size').val(),
              font_variant = $this.find('.themeatelier-core--font-variant').val(),
              line_height = $this.find('.themeatelier-core--line-height').val(),
              text_align = $this.find('.themeatelier-core--text-align').val(),
              text_transform = $this.find('.themeatelier-core--text-transform').val(),
              text_decoration = $this.find('.themeatelier-core--text-decoration').val(),
              text_color = $this.find('.themeatelier-core--color').val(),
              word_spacing = $this.find('.themeatelier-core--word-spacing').val(),
              letter_spacing = $this.find('.themeatelier-core--letter-spacing').val(),
              custom_style = $this.find('.themeatelier-core--custom-style').val(),
              type = $this.find('.themeatelier-core--type').val();

            if (type === 'google') {
              base.load_google_font(font_family, font_weight, font_style);
            }

            var properties = {};

            if (font_family) { properties.fontFamily = font_family; }
            if (font_weight) { properties.fontWeight = font_weight; }
            if (font_style) { properties.fontStyle = font_style; }
            if (font_variant) { properties.fontVariant = font_variant; }
            if (font_size) { properties.fontSize = font_size + unit; }
            if (line_height) { properties.lineHeight = line_height + line_height_unit; }
            if (letter_spacing) { properties.letterSpacing = letter_spacing + unit; }
            if (word_spacing) { properties.wordSpacing = word_spacing + unit; }
            if (text_align) { properties.textAlign = text_align; }
            if (text_transform) { properties.textTransform = text_transform; }
            if (text_decoration) { properties.textDecoration = text_decoration; }
            if (text_color) { properties.color = text_color; }

            $preview.removeAttr('style');

            // Customs style attribute
            if (custom_style) { $preview.attr('style', custom_style); }

            $preview.css(properties);

          }, 100));

          // Preview black and white backgrounds trigger
          $preview_block.on('click', function () {

            $preview.toggleClass('themeatelier-core--black-background');

            var $toggle = $preview_block.find('.themeatelier-core--toggle');

            if ($toggle.hasClass('fa-toggle-off')) {
              $toggle.removeClass('fa-toggle-off').addClass('fa-toggle-on');
            } else {
              $toggle.removeClass('fa-toggle-on').addClass('fa-toggle-off');
            }

          });

          if (!$preview_block.hasClass('hidden')) {
            $this.trigger('change');
          }

        }

      };

      base.init();

    });
  };

  //
  // Field: upload
  //
  $.fn.THEMEATELIER_CORE_field_upload = function () {
    return this.each(function () {

      var $this = $(this),
        $input = $this.find('input'),
        $upload_button = $this.find('.themeatelier-core--button'),
        $remove_button = $this.find('.themeatelier-core--remove'),
        $preview_wrap = $this.find('.themeatelier-core--preview'),
        $preview_src = $this.find('.themeatelier-core--src'),
        $library = $upload_button.data('library') && $upload_button.data('library').split(',') || '',
        wp_media_frame;

      $upload_button.on('click', function (e) {

        e.preventDefault();

        if (typeof window.wp === 'undefined' || !window.wp.media || !window.wp.media.gallery) {
          return;
        }

        if (wp_media_frame) {
          wp_media_frame.open();
          return;
        }

        wp_media_frame = window.wp.media({
          library: {
            type: $library
          },
        });

        wp_media_frame.on('select', function () {

          var src;
          var attributes = wp_media_frame.state().get('selection').first().attributes;

          if ($library.length && $library.indexOf(attributes.subtype) === -1 && $library.indexOf(attributes.type) === -1) {
            return;
          }

          $input.val(attributes.url).trigger('change');

        });

        wp_media_frame.open();

      });

      $remove_button.on('click', function (e) {
        e.preventDefault();
        $input.val('').trigger('change');
      });

      $input.on('change', function (e) {

        var $value = $input.val();

        if ($value) {
          $remove_button.removeClass('hidden');
        } else {
          $remove_button.addClass('hidden');
        }

        if ($preview_wrap.length) {

          if ($.inArray($value.split('.').pop().toLowerCase(), ['jpg', 'jpeg', 'gif', 'png', 'svg', 'webp']) !== -1) {
            $preview_wrap.removeClass('hidden');
            $preview_src.attr('src', $value);
          } else {
            $preview_wrap.addClass('hidden');
          }

        }

      });

    });

  };

  //
  // Field: wp_editor
  //
  $.fn.THEMEATELIER_CORE_field_wp_editor = function () {
    return this.each(function () {

      if (typeof window.wp.editor === 'undefined' || typeof window.tinyMCEPreInit === 'undefined' || typeof window.tinyMCEPreInit.mceInit.THEMEATELIER_CORE_wp_editor === 'undefined') {
        return;
      }

      var $this = $(this),
        $editor = $this.find('.themeatelier-core-wp-editor'),
        $textarea = $this.find('textarea');

      // If there is wp-editor remove it for avoid dupliated wp-editor conflicts.
      var $has_wp_editor = $this.find('.wp-editor-wrap').length || $this.find('.mce-container').length;

      if ($has_wp_editor) {
        $editor.empty();
        $editor.append($textarea);
        $textarea.css('display', '');
      }

      // Generate a unique id
      var uid = THEMEATELIER_CORE.helper.uid('themeatelier-core-editor-');

      $textarea.attr('id', uid);

      // Get default editor settings
      var default_editor_settings = {
        tinymce: window.tinyMCEPreInit.mceInit.THEMEATELIER_CORE_wp_editor,
        quicktags: window.tinyMCEPreInit.qtInit.THEMEATELIER_CORE_wp_editor
      };

      // Get default editor settings
      var field_editor_settings = $editor.data('editor-settings');

      // Callback for old wp editor
      var wpEditor = wp.oldEditor ? wp.oldEditor : wp.editor;

      if (wpEditor && wpEditor.hasOwnProperty('autop')) {
        wp.editor.autop = wpEditor.autop;
        wp.editor.removep = wpEditor.removep;
        wp.editor.initialize = wpEditor.initialize;
      }

      // Add on change event handle
      var editor_on_change = function (editor) {
        editor.on('change keyup', function () {
          var value = (field_editor_settings.wpautop) ? editor.getContent() : wp.editor.removep(editor.getContent());
          $textarea.val(value).trigger('change');
        });
      };

      // Extend editor selector and on change event handler
      default_editor_settings.tinymce = $.extend({}, default_editor_settings.tinymce, { selector: '#' + uid, setup: editor_on_change });

      // Override editor tinymce settings
      if (field_editor_settings.tinymce === false) {
        default_editor_settings.tinymce = false;
        $editor.addClass('themeatelier-core-no-tinymce');
      }

      // Override editor quicktags settings
      if (field_editor_settings.quicktags === false) {
        default_editor_settings.quicktags = false;
        $editor.addClass('themeatelier-core-no-quicktags');
      }

      // Wait until :visible
      var interval = setInterval(function () {
        if ($this.is(':visible')) {
          window.wp.editor.initialize(uid, default_editor_settings);
          clearInterval(interval);
        }
      });

      // Add Media buttons
      if (field_editor_settings.media_buttons && window.THEMEATELIER_CORE_media_buttons) {

        var $editor_buttons = $editor.find('.wp-media-buttons');

        if ($editor_buttons.length) {

          $editor_buttons.find('.themeatelier-core-shortcode-button').data('editor-id', uid);

        } else {

          var $media_buttons = $(window.THEMEATELIER_CORE_media_buttons);

          $media_buttons.find('.themeatelier-core-shortcode-button').data('editor-id', uid);

          $editor.prepend($media_buttons);

        }

      }

    });

  };

  //
  // Confirm
  //
  $.fn.THEMEATELIER_CORE_confirm = function () {
    return this.each(function () {
      $(this).on('click', function (e) {

        var confirm_text = $(this).data('confirm') || window.THEMEATELIER_CORE_vars.i18n.confirm;
        var confirm_answer = confirm(confirm_text);

        if (confirm_answer) {
          THEMEATELIER_CORE.vars.is_confirm = true;
          THEMEATELIER_CORE.vars.form_modified = false;
        } else {
          e.preventDefault();
          return false;
        }

      });
    });
  };

  $.fn.serializeObject = function () {

    var obj = {};

    $.each(this.serializeArray(), function (i, o) {
      var n = o.name,
        v = o.value;

      obj[n] = obj[n] === undefined ? v
        : $.isArray(obj[n]) ? obj[n].concat(v)
          : [obj[n], v];
    });

    return obj;

  };

  //
  // Options Save
  //
  $.fn.THEMEATELIER_CORE_save = function () {
    return this.each(function () {

      var $this = $(this),
        $buttons = $('.themeatelier-core-save'),
        $panel = $('.themeatelier-core-options'),
        flooding = false,
        timeout;

      $this.on('click', function (e) {

        if (!flooding) {

          var $text = $this.data('save'),
            $value = $this.val();

          $buttons.attr('value', $text);

          if ($this.hasClass('themeatelier-core-save-ajax')) {

            e.preventDefault();

            $panel.addClass('themeatelier-core-saving');
            $buttons.prop('disabled', true);

            window.wp.ajax.post('THEMEATELIER_CORE_' + $panel.data('unique') + '_ajax_save', {
              data: $('#themeatelier-core-form').serializeJSONTHEMEATELIER_CORE()
            })
              .done(function (response) {

                // clear errors
                $('.themeatelier-core-error').remove();

                if (Object.keys(response.errors).length) {

                  var error_icon = '<i class="themeatelier-core-label-error themeatelier-core-error">!</i>';

                  $.each(response.errors, function (key, error_message) {

                    var $field = $('[data-depend-id="' + key + '"]'),
                      $link = $('a[href="#tab=' + $field.closest('.themeatelier-core-section').data('section-id') + '"]'),
                      $tab = $link.closest('.themeatelier-core-tab-item');

                    $field.closest('.themeatelier-core-fieldset').append('<p class="themeatelier-core-error themeatelier-core-error-text">' + error_message + '</p>');

                    if (!$link.find('.themeatelier-core-error').length) {
                      $link.append(error_icon);
                    }

                    if (!$tab.find('.themeatelier-core-arrow .themeatelier-core-error').length) {
                      $tab.find('.themeatelier-core-arrow').append(error_icon);
                    }

                  });

                }

                $panel.removeClass('themeatelier-core-saving');
                $buttons.prop('disabled', false).attr('value', $value);
                flooding = false;

                THEMEATELIER_CORE.vars.form_modified = false;
                THEMEATELIER_CORE.vars.$form_warning.hide();

                clearTimeout(timeout);

                var $result_success = $('.themeatelier-core-form-success');
                $result_success.empty().append(response.notice).fadeIn('fast', function () {
                  timeout = setTimeout(function () {
                    $result_success.fadeOut('fast');
                  }, 1000);
                });

              })
              .fail(function (response) {
                alert(response.error);
              });

          } else {

            THEMEATELIER_CORE.vars.form_modified = false;

          }

        }

        flooding = true;

      });

    });
  };

  //
  // Option Framework
  //
  $.fn.THEMEATELIER_CORE_options = function () {
    return this.each(function () {

      var $this = $(this),
        $content = $this.find('.themeatelier-core-content'),
        $form_success = $this.find('.themeatelier-core-form-success'),
        $form_warning = $this.find('.themeatelier-core-form-warning'),
        $save_button = $this.find('.themeatelier-core-header .themeatelier-core-save');

      THEMEATELIER_CORE.vars.$form_warning = $form_warning;

      // Shows a message white leaving theme options without saving
      if ($form_warning.length) {

        window.onbeforeunload = function () {
          return (THEMEATELIER_CORE.vars.form_modified) ? true : undefined;
        };

        $content.on('change keypress', ':input', function () {
          if (!THEMEATELIER_CORE.vars.form_modified) {
            $form_success.hide();
            $form_warning.fadeIn('fast');
            THEMEATELIER_CORE.vars.form_modified = true;
          }
        });

      }

      if ($form_success.hasClass('themeatelier-core-form-show')) {
        setTimeout(function () {
          $form_success.fadeOut('fast');
        }, 1000);
      }

      $(document).keydown(function (event) {
        if ((event.ctrlKey || event.metaKey) && event.which === 83) {
          $save_button.trigger('click');
          event.preventDefault();
          return false;
        }
      });

    });
  };

  //
  // Taxonomy Framework
  //
  $.fn.THEMEATELIER_CORE_taxonomy = function () {
    return this.each(function () {

      var $this = $(this),
        $form = $this.parents('form');

      if ($form.attr('id') === 'addtag') {

        var $submit = $form.find('#submit'),
          $cloned = $this.find('.themeatelier-core-field').THEMEATELIER_CORE_clone();

        $submit.on('click', function () {

          if (!$form.find('.form-required').hasClass('form-invalid')) {

            $this.data('inited', false);

            $this.empty();

            $this.html($cloned);

            $cloned = $cloned.THEMEATELIER_CORE_clone();

            $this.THEMEATELIER_CORE_reload_script();

          }

        });

      }

    });
  };

  //
  // Shortcode Framework
  //
  $.fn.THEMEATELIER_CORE_shortcode = function () {

    var base = this;

    base.shortcode_parse = function (serialize, key) {

      var shortcode = '';

      $.each(serialize, function (shortcode_key, shortcode_values) {

        key = (key) ? key : shortcode_key;

        shortcode += '[' + key;

        $.each(shortcode_values, function (shortcode_tag, shortcode_value) {

          if (shortcode_tag === 'content') {

            shortcode += ']';
            shortcode += shortcode_value;
            shortcode += '[/' + key + '';

          } else {

            shortcode += base.shortcode_tags(shortcode_tag, shortcode_value);

          }

        });

        shortcode += ']';

      });

      return shortcode;

    };

    base.shortcode_tags = function (shortcode_tag, shortcode_value) {

      var shortcode = '';

      if (shortcode_value !== '') {

        if (typeof shortcode_value === 'object' && !$.isArray(shortcode_value)) {

          $.each(shortcode_value, function (sub_shortcode_tag, sub_shortcode_value) {

            // sanitize spesific key/value
            switch (sub_shortcode_tag) {

              case 'background-image':
                sub_shortcode_value = (sub_shortcode_value.url) ? sub_shortcode_value.url : '';
                break;

            }

            if (sub_shortcode_value !== '') {
              shortcode += ' ' + sub_shortcode_tag + '="' + sub_shortcode_value.toString() + '"';
            }

          });

        } else {

          shortcode += ' ' + shortcode_tag + '="' + shortcode_value.toString() + '"';

        }

      }

      return shortcode;

    };

    base.insertAtChars = function (_this, currentValue) {

      var obj = (typeof _this[0].name !== 'undefined') ? _this[0] : _this;

      if (obj.value.length && typeof obj.selectionStart !== 'undefined') {
        obj.focus();
        return obj.value.substring(0, obj.selectionStart) + currentValue + obj.value.substring(obj.selectionEnd, obj.value.length);
      } else {
        obj.focus();
        return currentValue;
      }

    };

    base.send_to_editor = function (html, editor_id) {

      var tinymce_editor;

      if (typeof tinymce !== 'undefined') {
        tinymce_editor = tinymce.get(editor_id);
      }

      if (tinymce_editor && !tinymce_editor.isHidden()) {
        tinymce_editor.execCommand('mceInsertContent', false, html);
      } else {
        var $editor = $('#' + editor_id);
        $editor.val(base.insertAtChars($editor, html)).trigger('change');
      }

    };

    return this.each(function () {

      var $modal = $(this),
        $load = $modal.find('.themeatelier-core-modal-load'),
        $content = $modal.find('.themeatelier-core-modal-content'),
        $insert = $modal.find('.themeatelier-core-modal-insert'),
        $loading = $modal.find('.themeatelier-core-modal-loading'),
        $select = $modal.find('select'),
        modal_id = $modal.data('modal-id'),
        nonce = $modal.data('nonce'),
        editor_id,
        target_id,
        gutenberg_id,
        sc_key,
        sc_name,
        sc_view,
        sc_group,
        $cloned,
        $button;

      $(document).on('click', '.themeatelier-core-shortcode-button[data-modal-id="' + modal_id + '"]', function (e) {

        e.preventDefault();

        $button = $(this);
        editor_id = $button.data('editor-id') || false;
        target_id = $button.data('target-id') || false;
        gutenberg_id = $button.data('gutenberg-id') || false;

        $modal.removeClass('hidden');

        // single usage trigger first shortcode
        if ($modal.hasClass('themeatelier-core-shortcode-single') && sc_name === undefined) {
          $select.trigger('change');
        }

      });

      $select.on('change', function () {

        var $option = $(this);
        var $selected = $option.find(':selected');

        sc_key = $option.val();
        sc_name = $selected.data('shortcode');
        sc_view = $selected.data('view') || 'normal';
        sc_group = $selected.data('group') || sc_name;

        $load.empty();

        if (sc_key) {

          $loading.show();

          window.wp.ajax.post('themeatelier-core-get-shortcode-' + modal_id, {
            shortcode_key: sc_key,
            nonce: nonce
          })
            .done(function (response) {

              $loading.hide();

              var $appended = $(response.content).appendTo($load);

              $insert.parent().removeClass('hidden');

              $cloned = $appended.find('.themeatelier-core--repeat-shortcode').THEMEATELIER_CORE_clone();

              $appended.THEMEATELIER_CORE_reload_script();
              $appended.find('.themeatelier-core-fields').THEMEATELIER_CORE_reload_script();

            });

        } else {

          $insert.parent().addClass('hidden');

        }

      });

      $insert.on('click', function (e) {

        e.preventDefault();

        if ($insert.prop('disabled') || $insert.attr('disabled')) { return; }

        var shortcode = '';
        var serialize = $modal.find('.themeatelier-core-field:not(.themeatelier-core-depend-on)').find(':input:not(.ignore)').serializeObjectTHEMEATELIER_CORE();

        switch (sc_view) {

          case 'contents':
            var contentsObj = (sc_name) ? serialize[sc_name] : serialize;
            $.each(contentsObj, function (sc_key, sc_value) {
              var sc_tag = (sc_name) ? sc_name : sc_key;
              shortcode += '[' + sc_tag + ']' + sc_value + '[/' + sc_tag + ']';
            });
            break;

          case 'group':

            shortcode += '[' + sc_name;
            $.each(serialize[sc_name], function (sc_key, sc_value) {
              shortcode += base.shortcode_tags(sc_key, sc_value);
            });
            shortcode += ']';
            shortcode += base.shortcode_parse(serialize[sc_group], sc_group);
            shortcode += '[/' + sc_name + ']';

            break;

          case 'repeater':
            shortcode += base.shortcode_parse(serialize[sc_group], sc_group);
            break;

          default:
            shortcode += base.shortcode_parse(serialize);
            break;

        }

        shortcode = (shortcode === '') ? '[' + sc_name + ']' : shortcode;

        if (gutenberg_id) {

          var content = window.THEMEATELIER_CORE_gutenberg_props.attributes.hasOwnProperty('shortcode') ? window.THEMEATELIER_CORE_gutenberg_props.attributes.shortcode : '';
          window.THEMEATELIER_CORE_gutenberg_props.setAttributes({ shortcode: content + shortcode });

        } else if (editor_id) {

          base.send_to_editor(shortcode, editor_id);

        } else {

          var $textarea = (target_id) ? $(target_id) : $button.parent().find('textarea');
          $textarea.val(base.insertAtChars($textarea, shortcode)).trigger('change');

        }

        $modal.addClass('hidden');

      });

      $modal.on('click', '.themeatelier-core--repeat-button', function (e) {

        e.preventDefault();

        var $repeatable = $modal.find('.themeatelier-core--repeatable');
        var $new_clone = $cloned.THEMEATELIER_CORE_clone();
        var $remove_btn = $new_clone.find('.themeatelier-core-repeat-remove');

        var $appended = $new_clone.appendTo($repeatable);

        $new_clone.find('.themeatelier-core-fields').THEMEATELIER_CORE_reload_script();

        THEMEATELIER_CORE.helper.name_nested_replace($modal.find('.themeatelier-core--repeat-shortcode'), sc_group);

        $remove_btn.on('click', function () {

          $new_clone.remove();

          THEMEATELIER_CORE.helper.name_nested_replace($modal.find('.themeatelier-core--repeat-shortcode'), sc_group);

        });

      });

      $modal.on('click', '.themeatelier-core-modal-close, .themeatelier-core-modal-overlay', function () {
        $modal.addClass('hidden');
      });

    });
  };

  //
  // WP Color Picker
  //
  if (typeof Color === 'function') {

    Color.prototype.toString = function () {

      if (this._alpha < 1) {
        return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
      }

      var hex = parseInt(this._color, 10).toString(16);

      if (this.error) { return ''; }

      if (hex.length < 6) {
        for (var i = 6 - hex.length - 1; i >= 0; i--) {
          hex = '0' + hex;
        }
      }

      return '#' + hex;

    };

  }

  THEMEATELIER_CORE.funcs.parse_color = function (color) {

    var value = color.replace(/\s+/g, ''),
      trans = (value.indexOf('rgba') !== -1) ? parseFloat(value.replace(/^.*,(.+)\)/, '$1') * 100) : 100,
      rgba = (trans < 100) ? true : false;

    return { value: value, transparent: trans, rgba: rgba };

  };

  $.fn.THEMEATELIER_CORE_color = function () {
    return this.each(function () {

      var $input = $(this),
        picker_color = THEMEATELIER_CORE.funcs.parse_color($input.val()),
        palette_color = window.THEMEATELIER_CORE_vars.color_palette.length ? window.THEMEATELIER_CORE_vars.color_palette : true,
        $container;

      // Destroy and Reinit
      if ($input.hasClass('wp-color-picker')) {
        $input.closest('.wp-picker-container').after($input).remove();
      }

      $input.wpColorPicker({
        palettes: palette_color,
        change: function (event, ui) {

          var ui_color_value = ui.color.toString();

          $container.removeClass('themeatelier-core--transparent-active');
          $container.find('.themeatelier-core--transparent-offset').css('background-color', ui_color_value);
          $input.val(ui_color_value).trigger('change');

        },
        create: function () {

          $container = $input.closest('.wp-picker-container');

          var a8cIris = $input.data('a8cIris'),
            $transparent_wrap = $('<div class="themeatelier-core--transparent-wrap">' +
              '<div class="themeatelier-core--transparent-slider"></div>' +
              '<div class="themeatelier-core--transparent-offset"></div>' +
              '<div class="themeatelier-core--transparent-text"></div>' +
              '<div class="themeatelier-core--transparent-button">transparent <i class="icofont-toggle-off"></i></div>' +
              '</div>').appendTo($container.find('.wp-picker-holder')),
            $transparent_slider = $transparent_wrap.find('.themeatelier-core--transparent-slider'),
            $transparent_text = $transparent_wrap.find('.themeatelier-core--transparent-text'),
            $transparent_offset = $transparent_wrap.find('.themeatelier-core--transparent-offset'),
            $transparent_button = $transparent_wrap.find('.themeatelier-core--transparent-button');

          if ($input.val() === 'transparent') {
            $container.addClass('themeatelier-core--transparent-active');
          }

          $transparent_button.on('click', function () {
            if ($input.val() !== 'transparent') {
              $input.val('transparent').trigger('change').removeClass('iris-error');
              $container.addClass('themeatelier-core--transparent-active');
            } else {
              $input.val(a8cIris._color.toString()).trigger('change');
              $container.removeClass('themeatelier-core--transparent-active');
            }
          });

          $transparent_slider.slider({
            value: picker_color.transparent,
            step: 1,
            min: 0,
            max: 100,
            slide: function (event, ui) {

              var slide_value = parseFloat(ui.value / 100);
              a8cIris._color._alpha = slide_value;
              $input.wpColorPicker('color', a8cIris._color.toString());
              $transparent_text.text((slide_value === 1 || slide_value === 0 ? '' : slide_value));

            },
            create: function () {

              var slide_value = parseFloat(picker_color.transparent / 100),
                text_value = slide_value < 1 ? slide_value : '';

              $transparent_text.text(text_value);
              $transparent_offset.css('background-color', picker_color.value);

              $container.on('click', '.wp-picker-clear', function () {

                a8cIris._color._alpha = 1;
                $transparent_text.text('');
                $transparent_slider.slider('option', 'value', 100);
                $container.removeClass('themeatelier-core--transparent-active');
                $input.trigger('change');

              });

              $container.on('click', '.wp-picker-default', function () {

                var default_color = THEMEATELIER_CORE.funcs.parse_color($input.data('default-color')),
                  default_value = parseFloat(default_color.transparent / 100),
                  default_text = default_value < 1 ? default_value : '';

                a8cIris._color._alpha = default_value;
                $transparent_text.text(default_text);
                $transparent_slider.slider('option', 'value', default_color.transparent);

                if (default_color.value === 'transparent') {
                  $input.removeClass('iris-error');
                  $container.addClass('themeatelier-core--transparent-active');
                }

              });

            }
          });
        }
      });

    });
  };

  //
  // ChosenJS
  //
  $.fn.THEMEATELIER_CORE_chosen = function () {
    return this.each(function () {

      var $this = $(this),
        $inited = $this.parent().find('.chosen-container'),
        is_sortable = $this.hasClass('themeatelier-core-chosen-sortable') || false,
        is_ajax = $this.hasClass('themeatelier-core-chosen-ajax') || false,
        is_multiple = $this.attr('multiple') || false,
        set_width = is_multiple ? '100%' : 'auto',
        set_options = $.extend({
          allow_single_deselect: true,
          disable_search_threshold: 10,
          width: set_width,
          no_results_text: window.THEMEATELIER_CORE_vars.i18n.no_results_text,
        }, $this.data('chosen-settings'));

      if ($inited.length) {
        $inited.remove();
      }

      // Chosen ajax
      if (is_ajax) {

        var set_ajax_options = $.extend({
          data: {
            type: 'post',
            nonce: '',
          },
          allow_single_deselect: true,
          disable_search_threshold: -1,
          width: '100%',
          min_length: 3,
          type_delay: 500,
          typing_text: window.THEMEATELIER_CORE_vars.i18n.typing_text,
          searching_text: window.THEMEATELIER_CORE_vars.i18n.searching_text,
          no_results_text: window.THEMEATELIER_CORE_vars.i18n.no_results_text,
        }, $this.data('chosen-settings'));

        $this.THEMEATELIER_COREAjaxChosen(set_ajax_options);

      } else {

        $this.chosen(set_options);

      }

      // Chosen keep options order
      if (is_multiple) {

        var $hidden_select = $this.parent().find('.themeatelier-core-hide-select');
        var $hidden_value = $hidden_select.val() || [];

        $this.on('change', function (obj, result) {

          if (result && result.selected) {
            $hidden_select.append('<option value="' + result.selected + '" selected="selected">' + result.selected + '</option>');
          } else if (result && result.deselected) {
            $hidden_select.find('option[value="' + result.deselected + '"]').remove();
          }

          // Force customize refresh
          if (window.wp.customize !== undefined && $hidden_select.children().length === 0 && $hidden_select.data('customize-setting-link')) {
            window.wp.customize.control($hidden_select.data('customize-setting-link')).setting.set('');
          }

          $hidden_select.trigger('change');

        });

        // Chosen order abstract
        $this.THEMEATELIER_COREChosenOrder($hidden_value, true);

      }

      // Chosen sortable
      if (is_sortable) {

        var $chosen_container = $this.parent().find('.chosen-container');
        var $chosen_choices = $chosen_container.find('.chosen-choices');

        $chosen_choices.bind('mousedown', function (event) {
          if ($(event.target).is('span')) {
            event.stopPropagation();
          }
        });

        $chosen_choices.sortable({
          items: 'li:not(.search-field)',
          helper: 'orginal',
          cursor: 'move',
          placeholder: 'search-choice-placeholder',
          start: function (e, ui) {
            ui.placeholder.width(ui.item.innerWidth());
            ui.placeholder.height(ui.item.innerHeight());
          },
          update: function (e, ui) {

            var select_options = '';
            var chosen_object = $this.data('chosen');
            var $prev_select = $this.parent().find('.themeatelier-core-hide-select');

            $chosen_choices.find('.search-choice-close').each(function () {
              var option_array_index = $(this).data('option-array-index');
              $.each(chosen_object.results_data, function (index, data) {
                if (data.array_index === option_array_index) {
                  select_options += '<option value="' + data.value + '" selected>' + data.value + '</option>';
                }
              });
            });

            $prev_select.children().remove();
            $prev_select.append(select_options);
            $prev_select.trigger('change');

          }
        });

      }

    });
  };

  //
  // Helper Checkbox Checker
  //
  $.fn.THEMEATELIER_CORE_checkbox = function () {
    return this.each(function () {

      var $this = $(this),
        $input = $this.find('.themeatelier-core--input'),
        $checkbox = $this.find('.themeatelier-core--checkbox');

      $checkbox.on('click', function () {
        $input.val(Number($checkbox.prop('checked'))).trigger('change');
      });

    });
  };

  //
  // Helper Check/Uncheck All
  //
  $.fn.THEMEATELIER_CORE_checkbox_all = function () {
    return this.each(function () {

      var $this = $(this);

      $this.on('click', function () {

        var $inputs = $this.closest('.themeatelier-core-field-checkbox').find(':input'),
          uncheck = false;

        $inputs.each(function () {
          if (!$(this).prop('checked')) {
            uncheck = true;
          }
        });

        if (uncheck) {
          $inputs.prop('checked', 'checked');
          $inputs.attr('checked', 'checked');
        } else {
          $inputs.prop('checked', '');
          $inputs.removeAttr('checked');
        }

        $inputs.first().trigger('change');

      });

    });
  };

  //
  // Siblings
  //
  $.fn.THEMEATELIER_CORE_siblings = function () {
    return this.each(function () {

      var $this = $(this),
        $siblings = $this.find('.themeatelier-core--sibling'),
        multiple = $this.data('multiple') || false;

      $siblings.on('click', function () {

        var $sibling = $(this);

        if (multiple) {

          if ($sibling.hasClass('themeatelier-core--active')) {
            $sibling.removeClass('themeatelier-core--active');
            $sibling.find('input').prop('checked', false).trigger('change');
          } else {
            $sibling.addClass('themeatelier-core--active');
            $sibling.find('input').prop('checked', true).trigger('change');
          }

        } else {

          $this.find('input').prop('checked', false);
          $sibling.find('input').prop('checked', true).trigger('change');
          $sibling.addClass('themeatelier-core--active').siblings().removeClass('themeatelier-core--active');

        }

      });

    });
  };

  //
  // Help Tooltip
  //
  $.fn.THEMEATELIER_CORE_help = function () {
    return this.each(function () {

      var $this = $(this),
        $tooltip,
        offset_left;

      $this.on({
        mouseenter: function () {
          $tooltip = $('<div class="themeatelier-core-tooltip-pro"></div>').html($this.find('.themeatelier-core-help-text').html()).appendTo('body');
          offset_left = (THEMEATELIER_CORE.vars.is_rtl) ? ($this.offset().left + 30) : ($this.offset().left + 30);

          $tooltip.css({
            top: $this.offset().top - (($tooltip.outerHeight() / 2) - 10),
            left: offset_left,
            textAlign: 'left',
          });

        },
        mouseleave: function () {
          if ($tooltip !== undefined) {
            if (!$tooltip.is(':hover')) {
              $tooltip.remove();
            }
          }
        }
      });
      // Event delegation to handle tooltip removal when the cursor leaves the tooltip itself.
      $('body').on('mouseleave', '.themeatelier-core-tooltip-pro', function () {
        if ($tooltip !== undefined) {
          $tooltip.remove();
        }
      });
    });
  };

  //
  // Customize Refresh
  //
  $.fn.THEMEATELIER_CORE_customizer_refresh = function () {
    return this.each(function () {

      var $this = $(this),
        $complex = $this.closest('.themeatelier-core-customize-complex');

      if ($complex.length) {

        var unique_id = $complex.data('unique-id');

        if (unique_id === undefined) {
          return;
        }

        var $input = $complex.find(':input'),
          option_id = $complex.data('option-id'),
          obj = $input.serializeObjectTHEMEATELIER_CORE(),
          data = (!$.isEmptyObject(obj) && obj[unique_id] && obj[unique_id][option_id]) ? obj[unique_id][option_id] : '',
          control = window.wp.customize.control(unique_id + '[' + option_id + ']');

        // clear the value to force refresh.
        control.setting._value = null;

        control.setting.set(data);

      } else {

        $this.find(':input').first().trigger('change');

      }

      $(document).trigger('themeatelier-core-customizer-refresh', $this);

    });
  };

  //
  // Customize Listen Form Elements
  //
  $.fn.THEMEATELIER_CORE_customizer_listen = function (options) {

    var settings = $.extend({
      closest: false,
    }, options);

    return this.each(function () {

      if (window.wp.customize === undefined) { return; }

      var $this = (settings.closest) ? $(this).closest('.themeatelier-core-customize-complex') : $(this),
        $input = $this.find(':input'),
        unique_id = $this.data('unique-id'),
        option_id = $this.data('option-id');

      if (unique_id === undefined) {
        return;
      }

      $input.on('change keyup themeatelier-core.change', function () {

        var obj = $this.find(':input').serializeObjectTHEMEATELIER_CORE();
        var val = (!$.isEmptyObject(obj) && obj[unique_id] && obj[unique_id][option_id]) ? obj[unique_id][option_id] : '';

        window.wp.customize.control(unique_id + '[' + option_id + ']').setting.set(val);

      });

    });
  };

  //
  // Customizer Listener for Reload JS
  //
  $(document).on('expanded', '.control-section', function () {

    var $this = $(this);

    if ($this.hasClass('open') && !$this.data('inited')) {

      var $fields = $this.find('.themeatelier-core-customize-field');
      var $complex = $this.find('.themeatelier-core-customize-complex');

      if ($fields.length) {
        $this.THEMEATELIER_CORE_dependency();
        $fields.THEMEATELIER_CORE_reload_script({ dependency: false });
        $complex.THEMEATELIER_CORE_customizer_listen();
      }

      $this.data('inited', true);

    }

  });

  //
  // Window on resize
  //
  THEMEATELIER_CORE.vars.$window.on('resize themeatelier-core.resize', THEMEATELIER_CORE.helper.debounce(function (event) {

    var window_width = navigator.userAgent.indexOf('AppleWebKit/') > -1 ? THEMEATELIER_CORE.vars.$window.width() : window.innerWidth;

    if (window_width <= 782 && !THEMEATELIER_CORE.vars.onloaded) {
      $('.themeatelier-core-section').THEMEATELIER_CORE_reload_script();
      THEMEATELIER_CORE.vars.onloaded = true;
    }

  }, 200)).trigger('themeatelier-core.resize');

  //
  // Widgets Framework
  //
  $.fn.THEMEATELIER_CORE_widgets = function () {
    return this.each(function () {

      $(document).on('widget-added widget-updated', function (event, $widget) {

        var $fields = $widget.find('.themeatelier-core-fields');

        if ($fields.length) {
          $fields.THEMEATELIER_CORE_reload_script();
        }

      });

      $(document).on('click', '.widget-top', function (event) {

        var $fields = $(this).parent().find('.themeatelier-core-fields');

        if ($fields.length) {
          $fields.THEMEATELIER_CORE_reload_script();
        }

      });

      $('.widgets-sortables, .control-section-sidebar').on('sortstop', function (event, ui) {
        ui.item.find('.themeatelier-core-fields').THEMEATELIER_CORE_reload_script_retry();
      });

    });
  };

  //
  // Nav Menu Options Framework
  //
  $.fn.THEMEATELIER_CORE_nav_menu = function () {
    return this.each(function () {

      var $navmenu = $(this);

      $navmenu.on('click', 'a.item-edit', function () {
        $(this).closest('li.menu-item').find('.themeatelier-core-fields').THEMEATELIER_CORE_reload_script();
      });

      $navmenu.on('sortstop', function (event, ui) {
        ui.item.find('.themeatelier-core-fields').THEMEATELIER_CORE_reload_script_retry();
      });

    });
  };

  //
  // Retry Plugins
  //
  $.fn.THEMEATELIER_CORE_reload_script_retry = function () {
    return this.each(function () {

      var $this = $(this);

      if ($this.data('inited')) {
        $this.children('.themeatelier-core-field-wp_editor').THEMEATELIER_CORE_field_wp_editor();
      }

    });
  };

  //
  // Reload Plugins
  //
  $.fn.THEMEATELIER_CORE_reload_script = function (options) {

    var settings = $.extend({
      dependency: true,
    }, options);

    return this.each(function () {

      var $this = $(this);

      // Avoid for conflicts
      if (!$this.data('inited')) {

        // Field plugins
        $this.children('.themeatelier-core-field-accordion').THEMEATELIER_CORE_field_accordion();
        $this.children('.themeatelier-core-field-backup').THEMEATELIER_CORE_field_backup();
        $this.children('.themeatelier-core-field-background').THEMEATELIER_CORE_field_background();
        $this.children('.themeatelier-core-field-code_editor').THEMEATELIER_CORE_field_code_editor();
        $this.children('.themeatelier-core-field-date').THEMEATELIER_CORE_field_date();
        $this.children('.themeatelier-core-field-datetime').THEMEATELIER_CORE_field_datetime();
        $this.children('.themeatelier-core-field-fieldset').THEMEATELIER_CORE_field_fieldset();
        $this.children('.themeatelier-core-field-gallery').THEMEATELIER_CORE_field_gallery();
        $this.children('.themeatelier-core-field-group').THEMEATELIER_CORE_field_group();
        $this.children('.themeatelier-core-field-icon').THEMEATELIER_CORE_field_icon();
        $this.children('.themeatelier-core-field-link').THEMEATELIER_CORE_field_link();
        $this.children('.themeatelier-core-field-media').THEMEATELIER_CORE_field_media();
        $this.children('.themeatelier-core-field-map').THEMEATELIER_CORE_field_map();
        $this.children('.themeatelier-core-field-repeater').THEMEATELIER_CORE_field_repeater();
        $this.children('.themeatelier-core-field-slider').THEMEATELIER_CORE_field_slider();
        $this.children('.themeatelier-core-field-sortable').THEMEATELIER_CORE_field_sortable();
        $this.children('.themeatelier-core-field-sorter').THEMEATELIER_CORE_field_sorter();
        $this.children('.themeatelier-core-field-spinner').THEMEATELIER_CORE_field_spinner();
        $this.children('.themeatelier-core-field-switcher').THEMEATELIER_CORE_field_switcher();
        $this.children('.themeatelier-core-field-section_tab').THEMEATELIER_CORE_field_section_tab();
        $this.children('.themeatelier-core-field-tabbed').THEMEATELIER_CORE_field_tabbed();
        $this.children('.themeatelier-core-field-typography').THEMEATELIER_CORE_field_typography();
        $this.children('.themeatelier-core-field-upload').THEMEATELIER_CORE_field_upload();
        $this.children('.themeatelier-core-field-wp_editor').THEMEATELIER_CORE_field_wp_editor();

        // Field colors
        $this.children('.themeatelier-core-field-border').find('.themeatelier-core-color').THEMEATELIER_CORE_color();
        $this.children('.themeatelier-core-field-background').find('.themeatelier-core-color').THEMEATELIER_CORE_color();
        $this.children('.themeatelier-core-field-color').find('.themeatelier-core-color').THEMEATELIER_CORE_color();
        $this.children('.themeatelier-core-field-color_group').find('.themeatelier-core-color').THEMEATELIER_CORE_color();
        $this.children('.themeatelier-core-field-link_color').find('.themeatelier-core-color').THEMEATELIER_CORE_color();
        $this.children('.themeatelier-core-field-typography').find('.themeatelier-core-color').THEMEATELIER_CORE_color();

        // Field chosenjs
        $this.children('.themeatelier-core-field-select').find('.themeatelier-core-chosen').THEMEATELIER_CORE_chosen();

        // Field Checkbox
        $this.children('.themeatelier-core-field-checkbox').find('.themeatelier-core-checkbox').THEMEATELIER_CORE_checkbox();
        $this.children('.themeatelier-core-field-checkbox').find('.themeatelier-core-checkbox-all').THEMEATELIER_CORE_checkbox_all();

        // Field Siblings
        $this.children('.themeatelier-core-field-button_set').find('.themeatelier-core-siblings').THEMEATELIER_CORE_siblings();
        $this.children('.themeatelier-core-field-image_select').find('.themeatelier-core-siblings').THEMEATELIER_CORE_siblings();
        $this.children('.themeatelier-core-field-layout_preset').find('.themeatelier-core-siblings').THEMEATELIER_CORE_siblings();
        $this.children('.themeatelier-core-field-palette').find('.themeatelier-core-siblings').THEMEATELIER_CORE_siblings();

        // Help Tooptip
        $this.children('.themeatelier-core-field').find('.themeatelier-core-help').THEMEATELIER_CORE_help();

        if (settings.dependency) {
          $this.THEMEATELIER_CORE_dependency();
        }

        $this.data('inited', true);

        $(document).trigger('themeatelier-core-reload-script', $this);

      }

    });
  };

  /* Copy to clipboard */
  $('.themeatelier-core-shortcode-selectable').on('click', function (e) {
    e.preventDefault();
    themeatelier_core_copyToClipboard($(this));
    themeatelier_core_SelectText($(this));
    $(this).trigger("focus").select();
    $('.themeatelier-core-after-copy-text').animate({
      opacity: 1,
      bottom: 25
    }, 300);
    setTimeout(function () {
      jQuery(".themeatelier-core-after-copy-text").animate({
        opacity: 0,
      }, 200);
      jQuery(".themeatelier-core-after-copy-text").animate({
        bottom: 0
      }, 0);
    }, 2000);
  });
  $('.themeatelier_core_input').on('click', function (e) {
    e.preventDefault();
    /* Get the text field */
    var copyText = $(this);
    /* Select the text field */
    copyText.select();
    document.execCommand("copy");
    $('.themeatelier-core-after-copy-text').animate({
      opacity: 1,
      bottom: 25
    }, 300);
    setTimeout(function () {
      jQuery(".themeatelier-core-after-copy-text").animate({
        opacity: 0,
      }, 200);
      jQuery(".themeatelier-core-after-copy-text").animate({
        bottom: 0
      }, 0);
    }, 2000);
  });
  function themeatelier_core_copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
  }
  function themeatelier_core_SelectText(element) {
    var r = document.createRange();
    var w = element.get(0);
    r.selectNodeContents(w);
    var sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(r);
  }

  //
  // Document ready and run scripts
  //
  $(document).ready(function () {

    $('.themeatelier-core-save').THEMEATELIER_CORE_save();
    $('.themeatelier-core-options').THEMEATELIER_CORE_options();
    $('.themeatelier-core-sticky-header').THEMEATELIER_CORE_sticky();
    $('.themeatelier-core-nav-options').THEMEATELIER_CORE_nav_options();
    $('.themeatelier-core-nav-metabox').THEMEATELIER_CORE_nav_metabox();
    $('.themeatelier-core-taxonomy').THEMEATELIER_CORE_taxonomy();
    $('.themeatelier-core-page-templates').THEMEATELIER_CORE_page_templates();
    $('.themeatelier-core-post-formats').THEMEATELIER_CORE_post_formats();
    $('.themeatelier-core-shortcode').THEMEATELIER_CORE_shortcode();
    $('.themeatelier-core-search').THEMEATELIER_CORE_search();
    $('.themeatelier-core-confirm').THEMEATELIER_CORE_confirm();
    $('.themeatelier-core-expand-all').THEMEATELIER_CORE_expand_all();
    $('.themeatelier-core-onload').THEMEATELIER_CORE_reload_script();
    $('#widgets-editor').THEMEATELIER_CORE_widgets();
    $('#widgets-right').THEMEATELIER_CORE_widgets();
    $('#menu-to-edit').THEMEATELIER_CORE_nav_menu();

  });
})(jQuery, window, document);

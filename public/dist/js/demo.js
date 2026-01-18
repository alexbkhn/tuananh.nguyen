/**
 * AdminLTE Demo Menu (Optimized)
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */

/* eslint-disable camelcase */

(function ($) {
  'use strict'

  // Show demo warning
  setTimeout(function () {
    if (window.___browserSync___ === undefined && Number(localStorage.getItem('AdminLTE:Demo:MessageShowed')) < Date.now()) {
      localStorage.setItem('AdminLTE:Demo:MessageShowed', Date.now() + 15 * 60 * 1000)
      alert('You load AdminLTE\'s "demo.js", \nthis file is only created for testing purposes!')
    }
  }, 1000)

  // Utility functions
  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1)
  }

  function createCheckbox(config) {
    var $checkbox = $('<input />', {
      type: 'checkbox',
      value: 1,
      checked: $(config.selector).hasClass(config.className),
      class: 'mr-1'
    }).on('click', function () {
      var $target = $(config.selector)
      var isChecked = $(this).is(':checked')
      
      if (isChecked) {
        $target.addClass(config.className)
      } else {
        $target.removeClass(config.className)
      }
      
      if (config.onToggle) {
        config.onToggle(isChecked)
      }
    })

    var $container = $('<div />', { class: config.containerClass || 'mb-1' })
      .append($checkbox)
      .append('<span>' + config.label + '</span>')

    return $container
  }

  function createSkinBlock(colors, callback, noneSelected) {
    var $block = $('<select />', {
      class: noneSelected ? 'custom-select mb-3 border-0' : 'custom-select mb-3 text-light border-0 ' + colors[0].replace(/accent-|navbar-/, 'bg-')
    })

    if (noneSelected) {
      $block.append($('<option />', { text: 'None Selected' }))
    }

    colors.forEach(function (color) {
      var cleanColor = typeof color === 'object' ? color.join(' ') : color
      var displayText = cleanColor.replace(/navbar-|accent-|bg-/, '').replace('-', ' ')
      
      $block.append($('<option />', {
        class: cleanColor.replace('navbar-', 'bg-').replace('accent-', 'bg-'),
        text: capitalizeFirstLetter(displayText)
      }))
    })

    if (callback) {
      $block.on('change', callback)
    }

    return $block
  }

  // Initialize UI
  var $sidebar = $('.control-sidebar')
  var $container = $('<div />', { class: 'p-3 control-sidebar-content' })

  $sidebar.append($container)
  $container.append('<h5>Customize AdminLTE</h5><hr class="mb-2"/>')

  // Checkbox configurations
  var checkboxConfigs = [
    { label: 'Dark Mode', selector: 'body', className: 'dark-mode', containerClass: 'mb-4' },
    { heading: 'Header Options' },
    { label: 'Fixed', selector: 'body', className: 'layout-navbar-fixed' },
    { label: 'Dropdown Legacy Offset', selector: '.main-header', className: 'dropdown-legacy' },
    { label: 'No border', selector: '.main-header', className: 'border-bottom-0', containerClass: 'mb-4' },
    { heading: 'Sidebar Options' },
    { label: 'Collapsed', selector: 'body', className: 'sidebar-collapse', onToggle: function() { $(window).trigger('resize') } },
    { label: 'Fixed', selector: 'body', className: 'layout-fixed', onToggle: function() { $(window).trigger('resize') } },
    { label: 'Sidebar Mini', selector: 'body', className: 'sidebar-mini' },
    { label: 'Sidebar Mini MD', selector: 'body', className: 'sidebar-mini-md' },
    { label: 'Sidebar Mini XS', selector: 'body', className: 'sidebar-mini-xs' },
    { label: 'Nav Flat Style', selector: '.nav-sidebar', className: 'nav-flat' },
    { label: 'Nav Legacy Style', selector: '.nav-sidebar', className: 'nav-legacy' },
    { label: 'Nav Compact', selector: '.nav-sidebar', className: 'nav-compact' },
    { label: 'Nav Child Indent', selector: '.nav-sidebar', className: 'nav-child-indent' },
    { label: 'Nav Child Hide on Collapse', selector: '.nav-sidebar', className: 'nav-collapse-hide-child' },
    { label: 'Disable Hover/Focus Auto-Expand', selector: '.main-sidebar', className: 'sidebar-no-expand', containerClass: 'mb-4' },
    { heading: 'Footer Options' },
    { label: 'Fixed', selector: 'body', className: 'layout-footer-fixed', containerClass: 'mb-4' },
    { heading: 'Small Text Options' },
    { label: 'Body', selector: 'body', className: 'text-sm' },
    { label: 'Navbar', selector: '.main-header', className: 'text-sm' },
    { label: 'Brand', selector: '.brand-link', className: 'text-sm' },
    { label: 'Sidebar Nav', selector: '.nav-sidebar', className: 'text-sm' },
    { label: 'Footer', selector: '.main-footer', className: 'text-sm', containerClass: 'mb-4' }
  ]

  // Render checkboxes
  var currentHeading = null
  checkboxConfigs.forEach(function (config) {
    if (config.heading) {
      if (currentHeading !== config.heading) {
        $container.append('<h6>' + config.heading + '</h6>')
        currentHeading = config.heading
      }
    } else {
      $container.append(createCheckbox(config))
    }
  })

  // Handle sidebar collapse/expand events
  $(document).on('collapsed.lte.pushmenu shown.lte.pushmenu', '[data-widget="pushmenu"]', function (e) {
    var isCollapsed = e.type === 'collapsed'
    $container.find('input[type="checkbox"]').first().prop('checked', isCollapsed)
  })

  // Color definitions
  var colors = {
    navbar_dark: ['navbar-primary', 'navbar-secondary', 'navbar-info', 'navbar-success', 'navbar-danger', 'navbar-indigo', 'navbar-purple', 'navbar-pink', 'navbar-navy', 'navbar-lightblue', 'navbar-teal', 'navbar-cyan', 'navbar-dark', 'navbar-gray-dark', 'navbar-gray'],
    navbar_light: ['navbar-light', 'navbar-warning', 'navbar-white', 'navbar-orange'],
    sidebar_colors: ['bg-primary', 'bg-warning', 'bg-info', 'bg-danger', 'bg-success', 'bg-indigo', 'bg-lightblue', 'bg-navy', 'bg-purple', 'bg-fuchsia', 'bg-pink', 'bg-maroon', 'bg-orange', 'bg-lime', 'bg-teal', 'bg-olive'],
    accent: ['accent-primary', 'accent-warning', 'accent-info', 'accent-danger', 'accent-success', 'accent-indigo', 'accent-lightblue', 'accent-navy', 'accent-purple', 'accent-fuchsia', 'accent-pink', 'accent-maroon', 'accent-orange', 'accent-lime', 'accent-teal', 'accent-olive'],
    sidebar_skins: ['sidebar-dark-primary', 'sidebar-dark-warning', 'sidebar-dark-info', 'sidebar-dark-danger', 'sidebar-dark-success', 'sidebar-dark-indigo', 'sidebar-dark-lightblue', 'sidebar-dark-navy', 'sidebar-dark-purple', 'sidebar-dark-fuchsia', 'sidebar-dark-pink', 'sidebar-dark-maroon', 'sidebar-dark-orange', 'sidebar-dark-lime', 'sidebar-dark-teal', 'sidebar-dark-olive', 'sidebar-light-primary', 'sidebar-light-warning', 'sidebar-light-info', 'sidebar-light-danger', 'sidebar-light-success', 'sidebar-light-indigo', 'sidebar-light-lightblue', 'sidebar-light-navy', 'sidebar-light-purple', 'sidebar-light-fuchsia', 'sidebar-light-pink', 'sidebar-light-maroon', 'sidebar-light-orange', 'sidebar-light-lime', 'sidebar-light-teal', 'sidebar-light-olive']
  }

  // Navbar color selector
  $container.append('<h6>Navbar Variants</h6>')
  var navbarAllColors = colors.navbar_dark.concat(colors.navbar_light)
  var $navbarSelect = createSkinBlock(navbarAllColors, function () {
    var color = $(this).find('option:selected').attr('class')
    var $header = $('.main-header')
    
    $header.removeClass('navbar-dark').removeClass('navbar-light')
    navbarAllColors.forEach(function (c) { $header.removeClass(c) })
    
    if (colors.navbar_dark.indexOf(color) > -1) {
      $header.addClass('navbar-dark').addClass(color).addClass('text-light')
    } else {
      $header.addClass('navbar-light').addClass(color)
    }
    
    $(this).removeClass().addClass('custom-select mb-3 text-light border-0 ' + color)
  })
  
  // Set active navbar color
  var activeNavbar = null
  $('.main-header')[0].classList.forEach(function (c) {
    if (navbarAllColors.indexOf(c) > -1 && !activeNavbar) activeNavbar = c.replace('navbar-', 'bg-')
  })
  if (activeNavbar) {
    $navbarSelect.find('option.' + activeNavbar).prop('selected', true)
    $navbarSelect.removeClass().addClass('custom-select mb-3 text-light border-0 ' + activeNavbar)
  }
  
  $container.append($navbarSelect)

  // Accent color selector
  $container.append('<h6>Accent Color Variants</h6>')
  $container.append(createSkinBlock(colors.accent, function () {
    var color = $(this).find('option:selected').attr('class')
    var $body = $('body')
    colors.accent.forEach(function (c) { $body.removeClass(c) })
    $body.addClass(color)
  }, true))

  // Dark sidebar selector
  $container.append('<h6>Dark Sidebar Variants</h6>')
  var $sidebarDarkSelect = createSkinBlock(colors.sidebar_colors, function () {
    var color = $(this).find('option:selected').attr('class')
    var sidebarClass = 'sidebar-dark-' + color.replace('bg-', '')
    var $sidebar = $('.main-sidebar')
    
    colors.sidebar_skins.forEach(function (c) { $sidebar.removeClass(c) })
    $sidebar.addClass(sidebarClass)
    $('.sidebar').removeClass('os-theme-dark').addClass('os-theme-light')
    
    $(this).removeClass().addClass('custom-select mb-3 text-light border-0 ' + color)
    $sidebarLightSelect.find('option').prop('selected', false)
  }, true)
  
  var activeSidebarDark = null
  $('.main-sidebar')[0].classList.forEach(function (c) {
    var color = c.replace('sidebar-dark-', 'bg-')
    if (colors.sidebar_colors.indexOf(color) > -1 && !activeSidebarDark) activeSidebarDark = color
  })
  if (activeSidebarDark) {
    $sidebarDarkSelect.find('option.' + activeSidebarDark).prop('selected', true)
    $sidebarDarkSelect.removeClass().addClass('custom-select mb-3 text-light border-0 ' + activeSidebarDark)
  }
  
  $container.append($sidebarDarkSelect)

  // Light sidebar selector
  $container.append('<h6>Light Sidebar Variants</h6>')
  var $sidebarLightSelect = createSkinBlock(colors.sidebar_colors, function () {
    var color = $(this).find('option:selected').attr('class')
    var sidebarClass = 'sidebar-light-' + color.replace('bg-', '')
    var $sidebar = $('.main-sidebar')
    
    colors.sidebar_skins.forEach(function (c) { $sidebar.removeClass(c) })
    $sidebar.addClass(sidebarClass)
    $('.sidebar').removeClass('os-theme-light').addClass('os-theme-dark')
    
    $(this).removeClass().addClass('custom-select mb-3 text-light border-0 ' + color)
    $sidebarDarkSelect.find('option').prop('selected', false)
  }, true)
  
  var activeSidebarLight = null
  $('.main-sidebar')[0].classList.forEach(function (c) {
    var color = c.replace('sidebar-light-', 'bg-')
    if (colors.sidebar_colors.indexOf(color) > -1 && !activeSidebarLight) activeSidebarLight = color
  })
  if (activeSidebarLight) {
    $sidebarLightSelect.find('option.' + activeSidebarLight).prop('selected', true)
    $sidebarLightSelect.removeClass().addClass('custom-select mb-3 text-light border-0 ' + activeSidebarLight)
  }
  
  $container.append($sidebarLightSelect)

  // Brand logo color selector
  $container.append('<h6>Brand Logo Variants</h6>')
  var $brandSelect = createSkinBlock(navbarAllColors, function () {
    var color = $(this).find('option:selected').attr('class')
    var $logo = $('.brand-link')
    
    navbarAllColors.forEach(function (c) { $logo.removeClass(c) })
    if (color) {
      $logo.addClass(color)
      if (color === 'navbar-light' || color === 'navbar-white') {
        $logo.addClass('text-black')
      } else {
        $logo.removeClass('text-black')
      }
    }
    
    var classes = 'custom-select mb-3 border-0 ' + color
    if (color && color !== 'navbar-light' && color !== 'navbar-white') classes += ' text-light'
    $(this).removeClass().addClass(classes)
  }, true)
  
  $brandSelect.append($('<a />', { href: '#', text: ' clear' }).on('click', function (e) {
    e.preventDefault()
    navbarAllColors.forEach(function (c) { $('.brand-link').removeClass(c) })
  }))
  
  var activeBrand = null
  $('.brand-link')[0].classList.forEach(function (c) {
    if (navbarAllColors.indexOf(c) > -1 && !activeBrand) activeBrand = c.replace('navbar-', 'bg-')
  })
  if (activeBrand) {
    $brandSelect.find('option.' + activeBrand).prop('selected', true)
    $brandSelect.removeClass().addClass('custom-select mb-3 text-light border-0 ' + activeBrand)
  }
  
  $container.append($brandSelect)
})(jQuery)

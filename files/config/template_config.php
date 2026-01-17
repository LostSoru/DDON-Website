<?php

# Assign Smarty Template Engine to a Variable #
$template = new Smarty\Smarty;

# Force Smarty to Recompile On Each Page Load #
$template->force_compile = false;

# Set the default layout directory #
$template->setTemplateDir('templates');

# Enable Smarty Debugging Mode #
$template->debugging = false;

# Enable Smarty Template Caching #
$template->caching = false;

# Smarty Template Cache Lifetime #
$template->cache_lifetime = 120;

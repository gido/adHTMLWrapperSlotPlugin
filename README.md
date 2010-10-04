# adHTMLWrapperSlotPlugin

This plugin is designed to work with the Apostrophe CMS by P'unk Ave. It allows developers to create templates that 
group Apostrophe slots and areas with custom HTML in-between.

## Installation

If you're using my asandbox project from GitHub (http://github.com/annismckenzie/asandbox) then just add the plugin as a submodule:

    $ git submodule add git://github.com/annismckenzie/adHTMLWrapperSlotPlugin.git "plugins/adHTMLWrapperSlotPlugin"
    $ git submodule update --init

Otherwise (in a non-git project), just add the git repository as a svn external. To do this, starting in the your symfony project directory, navigate to your plugins directory:

    $ cd plugins

Then add in the externals definition to the plugins directory.

    $ svn pe svn:externals .

This will bring up your default text editor, perhaps populated with any existing svn:externals you're using.  If you're using the asandbox as a starting point, the externals definition for the `plugins` directory
will look like this:

    sfJqueryReloadedPlugin http://svn.symfony-project.com/plugins/sfJqueryReloadedPlugin/1.2/trunk
    sfDoctrineGuardPlugin http://svn.symfony-project.com/plugins/sfDoctrineGuardPlugin/branches/1.3
    sfDoctrineActAsTaggablePlugin http://svn.symfony-project.com/plugins/sfDoctrineActAsTaggablePlugin/trunk
    sfSyncContentPlugin http://svn.symfony-project.com/plugins/sfSyncContentPlugin/trunk
    sfTaskExtraPlugin http://svn.symfony-project.com/plugins/sfTaskExtraPlugin/branches/1.3
    sfFeed2Plugin http://svn.symfony-project.com/plugins/sfFeed2Plugin/branches/1.2
    sfWebBrowserPlugin http://svn.symfony-project.com/plugins/sfWebBrowserPlugin/trunk
    apostrophePlugin http://svn.apostrophenow.org/plugins/apostrophePlugin/branches/1.4

To the bottom of this list, add:

    adHTMLWrapperSlotPlugin http://svn.github.com/annismckenzie/adHTMLWrapperSlotPlugin.git

And save the file.  To download the plugin files, do an SVN update in your plugins directory:

    $ svn up

We're done installing the plugin files.  Now, change back to your symfony project directory:

    $ cd ..

Next, you have to enable the `adHTMLWrapperSlot` module in your application's `settings.yml` file.  If the name of your application is, for example, `frontend`, then open `apps/frontend/config/settings.yml`, find the `enabled_modules` parameter, and add `adHTMLWrapperSlot` to the list.

Next, rebuild the model:

    $ ./symfony doctrine:build --all-classes

Next, add the plugin's slot type name, adHTMLWrapper, to the a_slot_types list in app.yml:

    all:
      a:
        slot_types:
          aBlog: Blog Posts
          ...
          adHTMLWrapper: Wrap in HTML

Next, copy the `lib/toolkit/aTools.class.php.copy_to_project_lib_toolkit` file (inside the plugin's lib directory) to your project's `lib/toolkit/aTools.class.php` file (if the toolkit directory doesn't exist, create it first). If, on the other hand, you already have the `lib/toolkit/aTools.class.php` file, instead change the base class of the class to `BaseaToolsHTMLWrapperSlotPlugin` (which itself inherits from `BaseaTools`).

Next, create a `adHTMLWrapperSlot` directory in your `apps/frontend/modules` directory and put a `templates` directory inside – this will hold your partials.

Next, copy the `modules/a/templates/_simpleEditWithVariants.php` file (inside the plugin's modules directory) to your project's `apps/frontend/modules/a/templates` directory.

At last, clear your cache:

    $ ./symfony cc

The adHTMLWrapperSlotPlugin is now ready to be used.

## Usage

Let's take an example to explain what this plugin does: you are tasked with creating an e-commerce site with Apostrophe. 
After finishing the site you need to explain to the client how to create a product. A product consists of a title, a description, 
a few pictures and yet more text.

You probably know that you can't encapsulate this product slot and nest all those Apostrophe slots inside, complete with wrapping divs 
for easy styling – you need to add these slots one-by-one. This plugin intends to make this not only possible but simple, too. :)

Now, have a look at the app.yml.sample file that shipped with this plugin – all you have to do to wrap Apostrophe slots in a custom template 
is the following. In your own frontend app's app.yml add this (look for the `slot_variants` key first, it's already there):

    all:
      a:
        slot_variants:
          adHTMLWrapper:
            product:
              label:            Product
              options:
                saveOnCreation: true
                showEditButton: false
                itemTemplate:   product

As you can see, we're defining a slot variant in the adHTMLWrapper section for the product with a few options. 
Because the product is only a template it doesn't need any user input; so we just save the slot on creation 
(Apostrophe slots normally don't do this) and hide the edit button. Finally, we define the partial that should be rendered: `_product.php`.

You'll then need to create this `_product.php` partial in the `apps/frontend/modules/adHTMLWrapperSlot/templates` directory you created earlier. 
The plugin ships with an example of how this partial could look like, you can find it inside the plugin's modules directory in `modules/adHTMLWrapperSlot/templates/_product.php`:

    <div class="dm_product clearfix">
      <div class="dm_product_picture">
        <?php a_slot("picture-$pageid-$name-$permid", 'aImage', array(
          'defaultImage' => '/uploads/defaultImages/defaultImage_product_slot.png', 'width' => 200, 'flexHeight' => true)) ?>
      </div>
      <div class="dm_product_content">
        <h3><?php a_slot("heading-$pageid-$name-$permid", 'aText') ?></h3>
        <?php a_slot("subheading-$pageid-$name-$permid", 'adHTMLWrapper', array('allowed_variants' => array('wrap_in_paragraphs'))) ?>
        <?php a_slot("description-$pageid-$name-$permid", 'aRichText') ?>
        
        <a href="http://www.example.com" target="_blank" class="link">
          Hard-coded link (okay, this is uncommon but it's also just an example!)
        </a><br /><br />
        <?php a_area("additional-text-$pageid-$name-$permid", array(
          'allowed_types' => array('aText', 'adHTMLWrapper'), 
          'type_options' => array(
            'aText' => array('label' => 'Additional simple text'),
            'adHTMLWrapper' => array('allowed_variants' => array('wrap_in_paragraphs'), 'label' => 'Additional paragraphs')
          ))) ?>
      </div>
      <hr class="product_divider" />
    </div>

A few notes:

  * Always include the $pageid, the $name, and the $permid variables in the slot names!
  * You can even nest areas inside – oh, the possibilities! :)
  * Yes, you can even nest adHTMLWrapper slots inside this!
  * because you are now using my extended version of aTools you can even give a slot type a label right in the a_slot call
  * because of the way Apostrophe handles slot variants when you only give it one allowed variant, you'll want to give that a descriptive label so your client knows he's adding a product

To use this fancy new product slot, add the following to on your page templates (for example `productsTemplate.php`) in the `body` area:

    <?php a_area('body', array(
    	'allowed_types' => array(..., 'adHTMLWrapper', 'aText', ...),
      'type_options' => array(
        ...
        'adHTMLWrapper' => array('allowed_variants' => array('product'), 'label' => 'Product')
    	))) ?>

## Known limitations

  * Currently, it's not possible to get the content of these slots indexed because I'll need to figure out a way to tell Apostrophe that we're nesting more slots inside and that it should index those. But maybe the P'unk Ave guys can help us out here? :)

I hope you can enjoy the flexibility this plugin gives you as much as I do and I also wanted to thank the P'unk Ave guys for an awesome CMS!

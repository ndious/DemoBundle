Demo Bundle
===================


This is the Demonstration Bundle provided with **BackBee Standard Edition**.
This Bundle provide some useful **Content Types** to build a blog or a news website.

----------

Content Types
-----------------

**block_demo**

Let's take a look to the related ``block_demo.yml`` located in the ``ClassContent`` directory.

```yaml
block_demo:
    properties:
        name: Block demo
        description: "Block for demonstration"
        category: [Demo]
    elements:
        text:
            type: BackBuilder\ClassContent\Element\text
            default:
                value: This is a random field you can edit...
            maxentry: 1
            parameters:
                aloha: !!scalar paragraph
                editable: !!boolean true
```

The root node of yaml tree is ``block_demo`` and he own two children: properties    and elements.

The properties are all related to the root node: for instance ``block_demo`` have a two mandatory parameters which are **name** and **description**.
The **category** parameter define a scope where the ClassContent be used in the BackBee application.


The elements define all elements (defined in BackBee Core, but you can create your owns) created when you use a ``block_demo`` Block in BackBee application.

This is pretty simple: a ``block_demo`` is compounded of only one **Text** element which is editable by the provided **Aloha editor**.

> **Note:**
> - If you update this file directly on BackBee in "debug mode", the modifications are applied when you reload your browser page
> - You need to provide also a template with your content type in the ``Templates\scripts`` directory
> - This documentation covers ``0.11.x`` versions of **BackBee CMS**


### Documentation links

  - [BackBee Standard Edition](http://www.backbee.com/) is a full-featured, open-source Content Management System (CMS) build on top of Symfony Components and Doctrine.
  - [Aloha editor](http://aloha-editor.org/) is an open source WYSIWYG editor that can be used in web pages. Aloha Editor aims to be easy to use and fast in editing, and allows advanced inline editing.

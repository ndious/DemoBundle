<?php

/*
 * Copyright (c) 2011-2015 Lp digital system
 *
 * This file is part of BackBee.
 *
 * BackBee is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * BackBee is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with BackBee. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Charles Rouillon <charles.rouillon@lp-digital.fr>
 */

namespace BackBee\Bundle\DemoBundle\Controller;

use BackBee\Bundle\AbstractAdminBundleController;
use BackBee\Bundle\DemoBundle\Entity\Item;

/**
 * @author      Nicolas Dufreche <nicolas.dufreche@lp-digital.fr>
 */
class AdminController extends AbstractAdminBundleController
{
    /**
     * Item index.
     *
     * @return string Index template
     */
    public function indexAction()
    {
        $items = $this->getRepository('BackBee\Bundle\DemoBundle\Entity\Item')
            ->findAll();

        return $this->render('Admin/Index.twig', ['items' => $items]);
    }

    /**
     * New item form.
     *
     * @return string form template
     */
    public function newAction()
    {
        return $this->render('Admin/Form.twig');
    }

    /**
     * Edit  item form.
     *
     * @param Int $id item id
     *
     * @return string form template
     */
    public function editAction($id)
    {
        $item = $this->getRepository('BackBee\Bundle\DemoBundle\Entity\Item')
            ->find($id);

        return $this->render('Admin/Form.twig', ['item' => $item]);
    }

    /**
     * Save item action.
     *
     * @return string Index template
     */
    public function saveAction($id = null)
    {
        $itemRepo = $this->getRepository('BackBee\Bundle\DemoBundle\Entity\Item');

        if (strtolower($this->getRequest()->getMethod()) === 'post') {
            $item = new Item();
        } else {
            $item = $itemRepo->find($id);
        }

        $item->setValue($this->getRequest()->request->get('label'));

        $em = $this->getEntityManager();
        $em->persist($item);
        $em->flush($item);

        $this->notifyUser(self::NOTIFY_SUCCESS, 'Item save success');

        return $this->indexAction();
    }

    /**
     * Delete selected item.
     *
     * @param Int $id item id
     *
     * @return string Index template
     */
    public function deleteAction($id)
    {
        $itemRepo = $this->getRepository('BackBee\Bundle\DemoBundle\Entity\Item');

        $item = $itemRepo->find($id);

        $em = $this->getEntityManager();
        $em->remove($item);
        $em->flush($item);

        return $this->indexAction();
    }
}

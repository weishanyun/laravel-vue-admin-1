<?php


namespace SmallRuralDog\Admin\Controllers;


use SmallRuralDog\Admin\Components\Avatar;
use SmallRuralDog\Admin\Components\Link;
use SmallRuralDog\Admin\Components\Tag;
use SmallRuralDog\Admin\Grid;

class UserController extends AdminController
{

    protected function showPageHeader()
    {
        return false;
    }

    protected function title()
    {
        return trans('admin.administrator');
    }
    protected function grid()
    {
        $userModel = config('admin.database.users_model');
        $grid = new Grid(new $userModel());

        $grid->setPageBackground();

        $grid->defaultSort('id', 'asc')->with(['roles:id,name', 'roles.permissions', 'roles.menus'])->selection();
        $grid->setStripe(true)->setEmptyText("暂无用户")->setPerPage(10);
        $column = $grid->column('id', "ID")->setWidth(80);
        $nameColumn = $grid->column('name', '用户昵称');
        $column->setLabelClassName('ClassName ClassName');
        $grid->columns([
            $column,
            $grid->column('avatar', '头像')->setWidth(80)->setAlign('center')->displayComponent(Avatar::make()),
            $grid->column('username', trans('admin.username'))->displayComponent(Link::make()),
            $nameColumn,
            $grid->column('roles.name', trans('admin.roles'))->displayComponent(Tag::make()->setEffect('dark')),
            $grid->column('roles.menus.title', trans('admin.roles'))->displayComponent(Tag::make()->setType()->setSize("mini")->setStyle(['margin-right'=>'5px'])),
            $grid->column('created_at', trans('admin.created_at')),
            $grid->column('updated_at', trans('admin.updated_at'))
        ]);
        return $grid;
    }

}

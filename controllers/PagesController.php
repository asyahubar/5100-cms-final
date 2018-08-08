<?php

namespace Cookbook\Controllers;


class PagesController
{
    public function home()
    {
        return view('home');
    }

    public function create()
    {
        return view('create');
    }

    public function edit($id)
    {
        return view('edit');
    }

    public function update($id)
    {
        return view('update');
    }

    public function destroy($id)
    {
        return view('destroy');
    }
}
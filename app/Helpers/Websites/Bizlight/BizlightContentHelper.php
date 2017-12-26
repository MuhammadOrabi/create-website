<?php

namespace App\Helpers\Websites\Bizlight;

use App\Section;
use App\Constant;
use App\Site;

class BizlightContentHelper
{
    public function createOrUpdate($request)
    {
        foreach ($request as $item) {
            if (isset($item['id'])) {
                $section = Section::findOrFail($item['id']);
                if ($section->title === 'showCase') {
                    $this->createOrUpdateShowCase($item);
                } elseif ($section->title === 'section_b') {
                    $this->createOrUpdateSectionB($item);
                } elseif ($section->title === 'section_a') {
                    $this->createOrUpdateSectionA($item);
                } elseif ($section->title === 'section_c') {
                    $this->createOrUpdateSectionC($item);
                } elseif ($section->title === 'aboutSection') {
                    $this->createOrUpdateAboutSection($item);
                } elseif ($section->title === 'servicesSection') {
                    $this->createOrUpdateServicesSection($item);
                }
            } elseif (isset($item['constant'])) {
                if ($item['constant'] === 'top-nav') {
                    $this->createOrUpdateTopNav($item);
                }
            }
        }
    }

    public function createOrUpdateShowCase($item)
    {
        $section = Section::where('id', $item['id'])->with('contents')->first();
        if ($section->contents->isEmpty()) {
            $section->contents()->create(['type' => 'heading', 'content' => $item['heading']]);
            $section->contents()->create(['type' => 'paragraph', 'content' => $item['paragraph']]);
        } else {
            $section->contents()->where('type', 'heading')->update(['content' => $item['heading']]);
            $section->contents()->where('type', 'paragraph')->update(['content' => $item['paragraph']]);
        }
    }

    public function createOrUpdateSectionB($item)
    {
        $section = Section::where('id', $item['id'])->with('contents')->first();
        if ($section->contents->isEmpty()) {
            $section->contents()->create(['type' => 'img', 'content' => $item['img']]);
            foreach ($item['data'] as $key => $data) {
                $section->contents()->create(['type' => 'heading', 'order' => ($key + 1), 'content' => $data['heading']]);
                $section->contents()->create(['type' => 'paragraph', 'order' => ($key + 1), 'content' => $data['paragraph']]);
            }
        } else {
            $section->contents()->where('type', 'img')->update(['content' => $item['img']]);
            foreach ($item['data'] as $key => $data) {
                if (isset($data['order'], $data['heading'], $data['paragraph'])) {
                    $section->contents()->where('type', 'heading')->where('order', $data['order'])->update(['content' => $data['heading']]);
                    $section->contents()->where('type', 'paragraph')->where('order', $data['order'])->update(['content' => $data['paragraph']]);
                } else {
                    $section->contents()->create(['type' => 'heading', 'order' => ($key + 1), 'content' => $data['heading']]);
                    $section->contents()->create(['type' => 'paragraph', 'order' => ($key + 1), 'content' => $data['paragraph']]);
                }
            }
            $this->removeNullContents($item['id']);
        }
    }

    public function createOrUpdateSectionA($item)
    {
        $section = Section::where('id', $item['id'])->with('contents')->first();
        if ($section->contents->isEmpty()) {
            foreach ($item['data'] as $key => $data) {
                $section->contents()->create(['type' => 'img', 'content' => $data['img'], 'order' => ($key + 1)]);
                $section->contents()->create(['type' => 'heading', 'order' => ($key + 1), 'content' => $data['heading']]);
                $section->contents()->create(['type' => 'paragraph', 'order' => ($key + 1), 'content' => $data['paragraph']]);
            }
        } else {
            foreach ($item['data'] as $key => $data) {
                if (isset($data['order'], $data['heading'], $data['paragraph'])) {
                    $section->contents()->where('type', 'heading')->where('order', $data['order'])->update(['content' => $data['heading']]);
                    $section->contents()->where('type', 'paragraph')->where('order', $data['order'])->update(['content' => $data['paragraph']]);
                    $section->contents()->where('type', 'img')->where('order', $data['order'])->update(['content' => $data['img']]);
                } else {
                    $section->contents()->create(['type' => 'heading', 'order' => ($key + 1), 'content' => $data['heading']]);
                    $section->contents()->create(['type' => 'paragraph', 'order' => ($key + 1), 'content' => $data['paragraph']]);
                    $section->contents()->create(['type' => 'img', 'order' => ($key + 1), 'content' => $data['img']]);
                }
            }
            $this->removeNullContents($item['id']);
        }
    }

    public function createOrUpdateSectionC($item)
    {
        $section = Section::where('id', $item['id'])->with('contents')->first();
        if ($section->contents->isEmpty()) {
            $section->contents()->create(['type' => 'img', 'content' => $item['img']]);
            $section->contents()->create(['type' => 'paragraph', 'content' => $item['paragraph']]);
        } else {
            $section->contents()->where('type', 'img')->update(['content' => $item['img']]);
            $section->contents()->where('type', 'paragraph')->update(['content' => $item['paragraph']]);
        }
    }

    public function createOrUpdateAboutSection($item)
    {
        $section = Section::where('id', $item['id'])->with('contents')->first();
        if ($section->contents->isEmpty()) {
            $section->contents()->create(['type' => 'paragraph', 'content' => $item['paragraph']]);
        } else {
            $section->contents()->where('type', 'paragraph')->update(['content' => $item['paragraph']]);
        }
    }

    public function createOrUpdateServicesSection($item)
    {
        $section = Section::where('id', $item['id'])->with('contents')->first();
        if ($section->contents->isEmpty()) {
            foreach ($item['data'] as $key => $data) {
                $section->contents()->create(['type' => 'heading', 'order' => ($key + 1), 'content' => $data['heading']]);
                $section->contents()->create(['type' => 'paragraph', 'order' => ($key + 1), 'content' => $data['paragraph']]);
            }
        } else {
            foreach ($item['data'] as $key => $data) {
                if (isset($data['order'], $data['heading'], $data['paragraph'])) {
                    $section->contents()->where('type', 'heading')->where('order', $data['order'])->update(['content' => $data['heading']]);
                    $section->contents()->where('type', 'paragraph')->where('order', $data['order'])->update(['content' => $data['paragraph']]);
                } else {
                    $section->contents()->create(['type' => 'heading', 'order' => ($key + 1), 'content' => $data['heading']]);
                    $section->contents()->create(['type' => 'paragraph', 'order' => ($key + 1), 'content' => $data['paragraph']]);
                }
            }
            $this->removeNullContents($item['id']);
        }
    }

    public function removeNullContents($id)
    {
        $section = Section::where('id', $id)->first();
        $section->contents()->where('content', null)->delete();
    }

    public function createOrUpdateTopNav($item)
    {
        $constant = Site::where('address', $item['address'])->first()->constants()->where('type', $item['constant'])->first();
        if ($constant->contents->isEmpty()) {
            $constant->contents()->create(['type' => 'link', 'title' => 'twitter', 'content' => $item['twitter']]);
            $constant->contents()->create(['type' => 'link', 'title' => 'facebook', 'content' => $item['facebook']]);
            $constant->contents()->create(['type' => 'link', 'title' => 'google-plus', 'content' => $item['google']]);
            $constant->contents()->create(['type' => 'link', 'title' => 'linkedin', 'content' => $item['linkedin']]);
            $constant->contents()->create(['type' => 'logo', 'content' => $item['logo']]);
        } else {
            $constant->contents()->where('title', 'twitter')->update(['content' => $item['twitter']]);
            $constant->contents()->where('title', 'facebook')->update(['content' => $item['facebook']]);
            $constant->contents()->where('title', 'google-plus')->update(['content' => $item['google']]);
            $constant->contents()->where('title', 'linkedin')->update(['content' => $item['linkedin']]);
            $constant->contents()->where('type', 'logo')->update(['content' => $item['logo']]);
        }
    }
}

<?php

namespace App\Orchid\Screens;

use App\Models\Post;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class PostScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'posts' => Post::paginate(15)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Post';
    }

    public function description(): ?string
    {
        return "Orchid Quickstart";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Add Post')
                ->modal('postModal')
                ->method('create')
                ->icon('plus'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::modal('postModal', Layout::rows([
                Input::make('post.title')
                    ->title('Name')
                    ->placeholder('Enter task name')
                    ->help('The name of the task to be created.'),
            ]))
                ->title('Create Post')
                ->applyButton('Add Post'),

            Layout::table('posts', [
                TD::make('title'),
                TD::make('enabled')
                    ->alignCenter()
                    ->render(fn (Post $post) => view('.icon', [
                        'icon' => 'circle',
                        'class' => implode(' ', ['me-2', 'text-' . ($post->enabled ? 'success' : 'danger')]),
                    ])),

                TD::make('draft')
                    ->alignCenter()
                    ->render(fn (Post $post) => view('.icon', [
                        'icon' => 'circle',
                        'class' => implode(' ', ['me-2', 'text-' . ($post->draft ? 'success' : 'danger')]),
                    ])),

                TD::make('Actions')
                    ->width(100)
                    ->alignRight()
                    ->render(function (Post $post) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make('Edit'),
                                Button::make('Delete')
                                    ->confirm(__('After deleting, the post will be gone forever.'))
                                    ->method('delete', [
                                        'post' => $post->id
                                    ])
                            ]);
                    }),
            ]),
        ];
    }
}

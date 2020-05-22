<?php

namespace Tests\Feature;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\UnauthorizedException;
use Tests\TestCase;

class QuestionsTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function user_sees_questions()
    {
        $questions = factory(Question::class, 5)->create();

        $response = $this->actingAs($this->user)->get(route('home'));
        $responseQuestions = $response->viewData('questions');

        $this->assertEquals($questions->pluck('id'), $responseQuestions->pluck('id'));
    }

    /** @test */
    public function guest_cannot_see_questions()
    {
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling()->get(route('home'));
    }

    /** @test */
    public function question_has_answers()
    {
        $question = factory(Question::class)->create();
        $question->answers()->saveMany(factory(Answer::class, 5)->make());

        $response = $this->actingAs($this->user)->get(route('home'));
        $responseQuestion = $response->viewData('questions')->keyBy('id')->get($question->id);

        $this->assertCount(5, $responseQuestion->answers);
    }

    /** @test */
    public function user_can_select_an_answer()
    {
        $question = factory(Question::class)->create();
        $question->answers()->saveMany(factory(Answer::class, 5)->make());

        $answer = $question->answers->random();

        $response = $this->actingAs($this->user)->post(route('questions.store', [$question, $answer]));

        $this->assertCount(1, $this->user->answers);
    }
}

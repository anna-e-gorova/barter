<?php

namespace App\Http\Middleware;

use App\Models\Chat;
use App\Models\VotedVoter;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCanRateAnotherUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $chat = new Chat();
        if (!($chat->whereRelation('users', 'users.id', $request->route('id'))->whereRelation('users', 'users.id', Auth::user()->id)->get()->first())) {
            return redirect()->back()->with(['fail' => 'Вы не можете оценивать этого продавца, Вы с ним еще не общались!']);
        }
        $votedVoter = new VotedVoter();
        if ($votedVoter->where('voter_id', Auth::user()->id)->where('voted_id', $request->route('id'))->get()->first()) {
            return redirect()->back()->with(['fail' => 'Вы не можете оценивать этого продавца, Вы уже ставили ему оценку!']);
        }
        return $next($request);
    }
}

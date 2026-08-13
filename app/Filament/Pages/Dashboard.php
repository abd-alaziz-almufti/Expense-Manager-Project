<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;
use App\Services\AiExpenseAdvisor;
use Illuminate\Support\HtmlString;
use App\Models\Category;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        return [
            // 🔹 زر النصائح
            Action::make('ai')
                ->label('نصائح الذكاء الاصطناعي | AI Advice')
                ->icon('heroicon-o-sparkles')
                ->color('amber')
                ->modalHeading('💡 مستشار المصاريف بالذكاء الاصطناعي | AI Advisor')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('إغلاق | Close')
                ->modalContent(function () {
                    $advice = app(AiExpenseAdvisor::class)
                        ->analyze(auth()->id());

                    return new HtmlString('
                        <div style="background: rgba(99, 102, 241, 0.05); padding: 1.25rem; border-radius: 0.75rem; border-left: 4px solid #6366f1; line-height: 1.7;">
                            ' . nl2br(e($advice)) . '
                        </div>
                    ');
                }),

            // 🔹 زر تحسين الخطة
            Action::make('optimizeBudget')
                ->label('تحسين الميزانية بالذكاء الاصطناعي | AI Budget')
                ->icon('heroicon-o-cpu-chip')
                ->color('primary')

                // 🧠 محتوى المودال (Before / After)
                ->modalHeading('🤖 الميزانية المحسنة بالذكاء الاصطناعي')
                ->modalContent(function () {
                    $service = app(AiExpenseAdvisor::class);
                    $plan = $service->optimizeBudget(auth()->id());

                    if (empty($plan)) {
                        return new HtmlString('<p class="text-sm text-gray-500">لا توجد اقتراحات تحسين متاحة حالياً.</p>');
                    }

                    $categories = Category::where('user_id', auth()->id())->get();

                    $rows = '';

                    foreach ($categories as $category) {
                        $old = $category->expected_amount;
                        $new = $plan[$category->name] ?? $old;

                        $changed = (float) $old !== (float) $new;

                        $rows .= "
                            <tr style='border-bottom: 1px solid rgba(0,0,0,0.05);'>
                                <td style='padding: 10px 12px; font-weight: 600;'>{$category->name}</td>
                                <td style='padding: 10px 12px;'>$" . number_format($old, 2) . "</td>
                                <td style='padding: 10px 12px; font-weight: 700; color: " . ($changed ? '#10b981' : 'inherit') . ";'>
                                    $" . number_format($new, 2) . "
                                    " . ($changed ? ' <span style="background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 9999px; font-size: 0.75rem;">تحديث ✔</span>' : '') . "
                                </td>
                            </tr>
                        ";
                    }

                    return new HtmlString("
                        <div style='overflow-x: auto; border-radius: 0.75rem; border: 1px solid rgba(0,0,0,0.08);'>
                            <table style='width:100%; border-collapse: collapse; text-align: right;'>
                                <thead>
                                    <tr style='background: rgba(99, 102, 241, 0.08); border-bottom: 2px solid rgba(0,0,0,0.08);'>
                                        <th style='padding: 12px;'>الفئة | Category</th>
                                        <th style='padding: 12px;'>الميزانية الحالية</th>
                                        <th style='padding: 12px;'>الميزانية المقترحة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {$rows}
                                </tbody>
                            </table>
                        </div>
                    ");
                })

                // ✅ زر Apply
                ->modalSubmitActionLabel('تطبيق خطة الذكاء الاصطناعي | Apply AI Plan')
                ->action(function () {
                    $service = app(AiExpenseAdvisor::class);
                    $plan = $service->optimizeBudget(auth()->id());

                    $changes = 0;

                    foreach ($plan as $categoryName => $amount) {
                        $category = Category::where('user_id', auth()->id())
                            ->whereRaw('LOWER(name) = ?', [strtolower($categoryName)])
                            ->first();

                        if (!$category) {
                            continue;
                        }

                        if ((float) $category->expected_amount !== (float) $amount) {
                            $category->update([
                                'expected_amount' => $amount,
                            ]);
                            $changes++;
                        }
                    }

                    Notification::make()
                        ->title(
                            $changes > 0
                            ? "تم تطبيق {$changes} تحسينات على الميزانية بنجاح 🎉"
                            : "الميزانية الحالية محسنة بالفعل!"
                        )
                        ->success()
                        ->send();
                }),

        ];
    }
}


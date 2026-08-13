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

                    $htmlAdvice = \Illuminate\Support\Str::markdown($advice);

                    return new HtmlString('
                        <div class="ai-modal-wrapper" style="font-family: inherit; direction: rtl; text-align: right;">
                            <!-- Header Banner -->
                            <div style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #9333ea 100%); padding: 1.25rem 1.5rem; border-radius: 1rem; color: #ffffff; margin-bottom: 1.25rem; box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.3);">
                                <div style="display: flex; align-items: center; gap: 0.85rem;">
                                    <div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); border-radius: 0.75rem; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0;">
                                        ✨
                                    </div>
                                    <div>
                                        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #ffffff;">تحليل المستشار المالي الذكي</h3>
                                        <p style="margin: 0.25rem 0 0 0; font-size: 0.85rem; color: rgba(255, 255, 255, 0.85);">نصائح مخصصة بناءً على سلوك إنفاقك هذا الشهر</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Advice Content Card -->
                            <div class="ai-advice-body" style="padding: 1.5rem; border-radius: 1rem; line-height: 1.8; font-size: 0.95rem;">
                                <style>
                                    .ai-advice-body {
                                        background: #ffffff;
                                        border: 1px solid rgba(99, 102, 241, 0.2);
                                        color: #1e293b;
                                    }
                                    .dark .ai-advice-body, html.dark .ai-advice-body, [data-theme="dark"] .ai-advice-body {
                                        background: rgba(15, 23, 42, 0.85) !important;
                                        border-color: rgba(99, 102, 241, 0.35) !important;
                                        color: #f1f5f9 !important;
                                    }
                                    .ai-advice-body h1, .ai-advice-body h2, .ai-advice-body h3, .ai-advice-body h4 {
                                        color: #4f46e5;
                                        font-weight: 700;
                                        margin-top: 1rem;
                                        margin-bottom: 0.5rem;
                                        border-bottom: 2px solid rgba(99, 102, 241, 0.15);
                                        padding-bottom: 0.35rem;
                                    }
                                    .dark .ai-advice-body h1, .dark .ai-advice-body h2, .dark .ai-advice-body h3, .dark .ai-advice-body h4,
                                    html.dark .ai-advice-body h1, html.dark .ai-advice-body h2, html.dark .ai-advice-body h3, html.dark .ai-advice-body h4 {
                                        color: #a5b4fc !important;
                                        border-bottom-color: rgba(165, 180, 252, 0.2) !important;
                                    }
                                    .ai-advice-body p {
                                        margin-bottom: 0.85rem;
                                    }
                                    .ai-advice-body ul, .ai-advice-body ol {
                                        padding-right: 1.25rem;
                                        margin-bottom: 1rem;
                                    }
                                    .ai-advice-body li {
                                        margin-bottom: 0.6rem;
                                        position: relative;
                                    }
                                    .ai-advice-body strong {
                                        color: #4338ca;
                                        font-weight: 700;
                                    }
                                    .dark .ai-advice-body strong, html.dark .ai-advice-body strong {
                                        color: #818cf8 !important;
                                    }
                                    .ai-advice-body blockquote {
                                        border-right: 4px solid #8b5cf6;
                                        background: rgba(139, 92, 246, 0.08);
                                        padding: 0.75rem 1rem;
                                        border-radius: 0.5rem;
                                        margin: 1rem 0;
                                        font-style: normal;
                                    }
                                </style>
                                ' . $htmlAdvice . '
                            </div>
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
                        return new HtmlString('
                            <div style="background: rgba(239, 68, 68, 0.05); padding: 1.25rem; border-radius: 0.75rem; border-left: 4px solid #ef4444; color: #b91c1c; line-height: 1.6;">
                                عذراً، تعذر إعداد اقتراحات تحسين الميزانية حالياً. يرجى المحاولة في وقت لاحق.
                            </div>
                        ');
                    }

                    $categories = Category::where('user_id', auth()->id())->get();

                    $rows = '';

                    foreach ($categories as $category) {
                        $old = (float) $category->expected_amount;
                        $new = (float) ($plan[$category->name] ?? $old);
                        $diff = $new - $old;
                        $changed = abs($diff) > 0.01;

                        $badge = '';
                        if ($changed) {
                            if ($diff < 0) {
                                $badge = '<span style="background: rgba(239, 68, 68, 0.12); color: #ef4444; padding: 3px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">⬇ خفض $' . number_format(abs($diff), 2) . '</span>';
                            } else {
                                $badge = '<span style="background: rgba(16, 185, 129, 0.12); color: #10b981; padding: 3px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">⬆ زيادة $' . number_format($diff, 2) . '</span>';
                            }
                        } else {
                            $badge = '<span style="opacity: 0.6; font-size: 0.75rem;">بدون تغيير</span>';
                        }

                        $rows .= "
                            <tr style='border-bottom: 1px solid rgba(156, 163, 175, 0.15);'>
                                <td style='padding: 12px 16px; font-weight: 600;'>{$category->name}</td>
                                <td style='padding: 12px 16px; opacity: 0.8;'>$" . number_format($old, 2) . "</td>
                                <td style='padding: 12px 16px; font-weight: 700; color: " . ($changed ? ($diff > 0 ? '#10b981' : '#f59e0b') : 'inherit') . ";'>
                                    $" . number_format($new, 2) . "
                                </td>
                                <td style='padding: 12px 16px; text-align: left;'>{$badge}</td>
                            </tr>
                        ";
                    }

                    return new HtmlString("
                        <div style='font-family: inherit; direction: rtl;'>
                            <!-- Header Banner -->
                            <div style='background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 50%, #4f46e5 100%); padding: 1.25rem 1.5rem; border-radius: 1rem; color: #ffffff; margin-bottom: 1.25rem; box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3);'>
                                <div style='display: flex; align-items: center; gap: 0.85rem;'>
                                    <div style='background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); border-radius: 0.75rem; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0;'>
                                        🤖
                                    </div>
                                    <div>
                                        <h3 style='margin: 0; font-size: 1.15rem; font-weight: 700; color: #ffffff;'>إعادة توزيع الميزانية الذكية</h3>
                                        <p style='margin: 0.25rem 0 0 0; font-size: 0.85rem; color: rgba(255, 255, 255, 0.85);'>مقارنة الميزانية الحالية والمقترحة من الذكاء الاصطناعي</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Table Card -->
                            <div class='ai-table-card' style='overflow-x: auto; border-radius: 1rem; border: 1px solid rgba(156, 163, 175, 0.2);'>
                                <style>
                                    .ai-table-card {
                                        background: #ffffff;
                                        color: #1e293b;
                                    }
                                    .dark .ai-table-card, html.dark .ai-table-card, [data-theme=\"dark\"] .ai-table-card {
                                        background: rgba(15, 23, 42, 0.85) !important;
                                        color: #f1f5f9 !important;
                                    }
                                </style>
                                <table style='width:100%; border-collapse: collapse; text-align: right; font-size: 0.95rem;'>
                                    <thead>
                                        <tr style='background: rgba(99, 102, 241, 0.08); border-bottom: 2px solid rgba(156, 163, 175, 0.2);'>
                                            <th style='padding: 12px 16px;'>الفئة | Category</th>
                                            <th style='padding: 12px 16px;'>الميزانية الحالية</th>
                                            <th style='padding: 12px 16px;'>الميزانية المقترحة</th>
                                            <th style='padding: 12px 16px; text-align: left;'>التعديل المقترح</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$rows}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    ");
                })



                // ✅ زر Apply
                ->modalSubmitActionLabel('تطبيق خطة الذكاء الاصطناعي | Apply AI Plan')
                ->action(function () {
                    $service = app(AiExpenseAdvisor::class);
                    $plan = $service->optimizeBudget(auth()->id());

                    if (empty($plan)) {
                        Notification::make()
                            ->title('عذراً، تعذر تطبيق خطة تحسين الميزانية حالياً. يرجى المحاولة لاحقاً.')
                            ->warning()
                            ->send();
                        return;
                    }

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


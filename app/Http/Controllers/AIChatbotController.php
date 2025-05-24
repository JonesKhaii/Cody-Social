<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIChatbotController extends Controller
{
    public function chat(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            $message = $validated['message'];
            Log::info("Received message: " . $message);

            $apiKey = env('GOOGLE_AI_API_KEY', 'AIzaSyDthqIhuHWzYlLQDCdq2Jxr0gejccThcTA');

            $modelName = "gemini-2.0-flash";

            Log::info("Making request to Google AI API using model: " . $modelName);

            $requestBody = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => "Bạn là trợ lý AI tư vấn y tế của ToiKhoe. Hãy trả lời ngắn gọn, chính xác và dễ hiểu. Luôn nhắc nhở người dùng tham khảo ý kiến bác sĩ cho chẩn đoán chính xác. Không trả lời quá dài dòng.\n\nCâu hỏi: " . $message
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 800,
                    'topP' => 0.8,
                    'topK' => 40
                ]
            ];

            Log::debug("Request body: " . json_encode($requestBody));

            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key={$apiKey}";
            Log::debug("Request URL: " . $url);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $requestBody);

            // Log response status and body for debugging
            Log::info("Google API status code: " . $response->status());
            Log::debug("Response body: " . $response->body());

            if ($response->failed()) {
                Log::error("Google API error: " . $response->body());

                $mockResponses = [
                    "Xin chào! Tôi là trợ lý AI y tế của ToiKhoe. Tôi có thể giúp gì cho bạn?",
                    "Để có chẩn đoán chính xác, bạn nên tham khảo ý kiến bác sĩ. Tuy nhiên, tôi có thể cung cấp một số thông tin chung.",
                    "Triệu chứng bạn mô tả có thể liên quan đến nhiều nguyên nhân khác nhau. Tốt nhất bạn nên đi khám để được tư vấn cụ thể.",
                    "Việc duy trì lối sống lành mạnh rất quan trọng cho sức khỏe tổng thể. Hãy đảm bảo ăn uống cân bằng, tập thể dục đều đặn và ngủ đủ giấc.",
                    "Tôi có thể giúp bạn cung cấp thông tin sức khỏe chung, nhưng không thể thay thế cho tư vấn y tế chuyên nghiệp."
                ];

                $mockResponse = $mockResponses[array_rand($mockResponses)];

                return response()->json([
                    'success' => true,
                    'message' => $mockResponse,
                    'note' => 'Đang sử dụng phản hồi mẫu do gặp lỗi kết nối với API.'
                ]);
            }

            $responseData = $response->json();

            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                $aiMessage = $responseData['candidates'][0]['content']['parts'][0]['text'];
                Log::info("AI response: " . $aiMessage);

                return response()->json([
                    'success' => true,
                    'message' => $aiMessage
                ]);
            } else {
                Log::error("Unexpected response structure: " . json_encode($responseData));

                $mockResponses = [
                    "Xin chào! Tôi là trợ lý AI y tế của ToiKhoe. Tôi có thể giúp gì cho bạn?",
                    "Để có chẩn đoán chính xác, bạn nên tham khảo ý kiến bác sĩ. Tuy nhiên, tôi có thể cung cấp một số thông tin chung.",
                    "Triệu chứng bạn mô tả có thể liên quan đến nhiều nguyên nhân khác nhau. Tốt nhất bạn nên đi khám để được tư vấn cụ thể.",
                    "Việc duy trì lối sống lành mạnh rất quan trọng cho sức khỏe tổng thể. Hãy đảm bảo ăn uống cân bằng, tập thể dục đều đặn và ngủ đủ giấc.",
                    "Tôi có thể giúp bạn cung cấp thông tin sức khỏe chung, nhưng không thể thay thế cho tư vấn y tế chuyên nghiệp."
                ];

                // Chọn ngẫu nhiên một phản hồi
                $mockResponse = $mockResponses[array_rand($mockResponses)];

                return response()->json([
                    'success' => true,
                    'message' => $mockResponse,
                    'note' => 'Đang sử dụng phản hồi mẫu do định dạng phản hồi API không như mong đợi.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Exception in AIChatbotController: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());

            // Trả về phản hồi giả lập nếu có lỗi
            $mockResponses = [
                "Xin chào! Tôi là trợ lý AI y tế của ToiKhoe. Tôi có thể giúp gì cho bạn?",
                "Để có chẩn đoán chính xác, bạn nên tham khảo ý kiến bác sĩ. Tuy nhiên, tôi có thể cung cấp một số thông tin chung.",
                "Triệu chứng bạn mô tả có thể liên quan đến nhiều nguyên nhân khác nhau. Tốt nhất bạn nên đi khám để được tư vấn cụ thể.",
                "Tôi có thể giúp bạn cung cấp thông tin sức khỏe chung, nhưng không thể thay thế cho tư vấn y tế chuyên nghiệp."
            ];

            // Chọn ngẫu nhiên một phản hồi
            $mockResponse = $mockResponses[array_rand($mockResponses)];

            return response()->json([
                'success' => true,
                'message' => $mockResponse,
                'note' => 'Đang sử dụng phản hồi mẫu do gặp ngoại lệ trong xử lý.'
            ]);
        }
    }
}

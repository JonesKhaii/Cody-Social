const fruitAttributes = {
    name: "Mango",           // Tên của loại hoa quả
    color: "Yellow",         // Màu sắc
    taste: "Sweet",          // Hương vị
    season: "Summer",        // Mùa thu hoạch
    isTropical: true,        // Có phải là trái cây nhiệt đới không
    nutrients: {             // Chất dinh dưỡng có trong trái cây
        vitaminC: "High",
        fiber: "Moderate",
        sugar: "Medium"
    },
    pricePerKg: 2.5,         // Giá mỗi kg (đơn vị: USD)
    availability: ["Market", "Supermarket", "Online"], // Nơi có thể mua
    benefits: [              // Lợi ích cho sức khỏe
        "Boosts Immunity",
        "Good for Digestion",
        "Rich in Antioxidants"
    ],
    similarFruits: ["Papaya", "Banana", "Pineapple"], // Các loại quả tương tự
    getDescription: function () {
        return `${this.name} is a ${this.color} fruit that tastes ${this.taste}. It is commonly found in ${this.season}.`;
    }
};

console.table(fruitAttributes);

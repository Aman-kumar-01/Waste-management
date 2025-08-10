document.getElementById('chat-btn').addEventListener('click', function () {
    var query = document.getElementById('chat-input').value;
    var results = document.getElementById('chat-results');

    if (query) {
        results.innerHTML = `<p>🔍 Searching for: <strong>${query}</strong></p>
                             <p>🤖 AI: Fetching the best waste management advice...</p>`;

        fetch(`https://api.openai.com/v1/completions`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer YOUR_OPENAI_API_KEY"
            },
            body: JSON.stringify({
                model: "gpt-3.5-turbo",
                messages: [{ role: "user", content: query }]
            })
        })
        .then(response => response.json())
        .then(data => {
            results.innerHTML = `<p>💡 <strong>AI Suggestion:</strong> ${data.choices[0].message.content}</p>`;
        })
        .catch(error => {
            results.innerHTML = `<p>⚠️ Error fetching AI response. Try again later.</p>`;
        });
    }
});

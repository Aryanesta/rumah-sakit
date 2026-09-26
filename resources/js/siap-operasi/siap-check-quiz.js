export function siapOperasiQuiz(questions, submitUrl, finalMessages) {
    return {
        questions,
        submitUrl,
        finalMessages,
        step: 0,
        answers: {},
        showFeedback: false,
        lastCorrect: false,
        feedbackText: '',
        finished: false,
        resultGood: false,
        score: 0,
        submitting: false,

        currentQuestion() {
            return this.questions[this.step];
        },

        selectOption(option) {
            if (this.finished) {
                return;
            }

            const question = this.currentQuestion();
            this.answers[question.id] = option;
            this.lastCorrect = option === question.correct;
            this.feedbackText = this.lastCorrect
                ? question.feedback_correct
                : question.feedback_incorrect;
            this.showFeedback = true;
        },

        nextStep() {
            this.showFeedback = false;

            if (this.step < this.questions.length - 1) {
                this.step++;

                return;
            }

            this.submit();
        },

        reviewRoute() {
            const question = this.currentQuestion();

            return question.review_route;
        },

        async submit() {
            this.submitting = true;

            try {
                const response = await fetch(this.submitUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ answers: this.answers }),
                });

                if (!response.ok) {
                    throw new Error('submit failed');
                }

                const data = await response.json();
                this.score = data.score;
                this.resultGood = data.understanding_good;
                this.finished = true;
            } catch {
                this.feedbackText = 'Gagal mengirim jawaban. Silakan coba lagi.';
                this.showFeedback = true;
            } finally {
                this.submitting = false;
            }
        },
    };
}

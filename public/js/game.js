// public/js/game.js
document.addEventListener('DOMContentLoaded', () => {
    const draggables = document.querySelectorAll('.draggable');
    const droppables = document.querySelectorAll('.droppable');
    let score = 0;
    let draggedElement = null;

    // Initialize game
    function initGame() {
        // Shuffle meanings
        const meaningsContainer = document.getElementById('meanings-container');
        for (let i = meaningsContainer.children.length; i >= 0; i--) {
            meaningsContainer.appendChild(meaningsContainer.children[Math.random() * i | 0]);
        }
    }

    // Drag events
    draggables.forEach(draggable => {
        draggable.addEventListener('dragstart', (e) => {
            draggedElement = draggable;
            draggable.classList.add('dragging');
        });

        draggable.addEventListener('dragend', () => {
            draggable.classList.remove('dragging');
            draggedElement = null;
        });
    });

    // Drop events
    droppables.forEach(droppable => {
        droppable.addEventListener('dragover', (e) => {
            e.preventDefault();
            droppable.classList.add('dragover');
        });

        droppable.addEventListener('dragleave', () => {
            droppable.classList.remove('dragover');
        });

        droppable.addEventListener('drop', (e) => {
            e.preventDefault();
            droppable.classList.remove('dragover');

            if (draggedElement) {
                const isCorrectMatch = draggedElement.dataset.name === droppable.dataset.pair;
                
                if (isCorrectMatch) {
                    // Match is correct
                    score += 20;
                    document.getElementById('score').textContent = `Skor: ${score}`;
                    
                    // Mark both elements as matched
                    draggedElement.classList.add('matched');
                    droppable.classList.add('matched');
                    
                    // Disable further interaction
                    draggedElement.draggable = false;
                    
                    // Check if game is complete
                    if (score === 100) {
                        setTimeout(() => {
                            alert('Selamat! Anda telah menyelesaikan permainan!');
                        }, 500);
                    }
                } else {
                    // Wrong match - shake effect
                    droppable.classList.add('shake');
                    setTimeout(() => {
                        droppable.classList.remove('shake');
                    }, 500);
                }
            }
        });
    });

    // Reset game
    window.resetGame = () => {
        score = 0;
        document.getElementById('score').textContent = 'Skor: 0';
        
        draggables.forEach(draggable => {
            draggable.classList.remove('matched');
            draggable.draggable = true;
        });
        
        droppables.forEach(droppable => {
            droppable.classList.remove('matched');
        });

        initGame();
    };

    // Initialize game on load
    initGame();
});
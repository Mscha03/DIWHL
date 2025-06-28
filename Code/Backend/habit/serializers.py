from rest_framework import serializers
from habit.models import Habit, HabitPattern, HabitLog
from habit.utils.enums import HabitFrequency


class HabitPatternSerializer(serializers.ModelSerializer):
    class Meta:
        model = HabitPattern
        fields = ['id','day']

class HabitLogSerializer(serializers.ModelSerializer):
    class Meta:
        model = HabitLog
        fields = ['id', 'habit', 'date', 'completion_state']


class HabitSerializer(serializers.ModelSerializer):
    patterns = HabitPatternSerializer(many=True)
    class Meta:
        model = Habit
        fields = ['id', 'user', 'title', 'description', 'state_mode', 'frequency', 'has_pattern', 'patterns']
        read_only_fields = ['created_at', 'updated_at']
        extra_kwargs = {
            'description': {'required': False},
        }

    def create(self, validated_data):

        validated_patterns = validated_data.pop('patterns', [])
        validated_frequency = validated_data.pop('frequency', None)

        patterns = check_pattern(
            frequency = validated_frequency,
            patterns = validated_patterns
        )

        if patterns:
            habit = Habit.objects.create(has_pattern=True,frequency=validated_frequency, **validated_data)
            for pattern in patterns:
                HabitPattern.objects.create(habit=habit, **pattern)
        else:
            habit = Habit.objects.create(frequency=validated_frequency, **validated_data)

        return habit


def check_pattern(frequency, patterns):
    match frequency:
        case HabitFrequency.DAILY.value:
            patterns.clear()
            print("daily habit, can't has pattern")

        case HabitFrequency.WEEKLY.value:
            for pattern in patterns:
                if pattern['day'] < 1  or pattern['day'] > 7:
                    print(pattern['day'])
                    patterns.remove(pattern)

        case HabitFrequency.MONTHLY.value:
            for pattern in patterns:
                if pattern['day'] < 1 or pattern['day'] > 31:
                    patterns.remove(pattern)

        case _:
            patterns.clear()
            print("{} not a frequency".format(frequency))


    return patterns